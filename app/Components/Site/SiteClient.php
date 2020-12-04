<?php

namespace App\Components\Site;

use App\Facades\RsaEncryption;
use App\Factories\FeedbackFactory;
use App\Helpers\SecretKeyHelper;
use App\Models\Site;
use App\Models\SiteTemplate;
use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * Class SiteClient
 * @package App\Components\Site
 */
class SiteClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var mixed
     */
    private $host;

    /**
     * @var FeedbackFactory
     */
    private $feedbackFactory;

    /**
     * @var string
     */
    const GET_SITE_PUBLIC_KEY_URL = '/api/get-public-key';


    /**
     * @var string
     */
    const GET_FEEDBACK_URL = '/api/get-feedback';

    /**
     * SiteClient constructor.
     */
    public function __construct(FeedbackFactory $feedbackFactory)
    {
        $this->host = env('APP_HUB_ADMIN_HOST', false);
        $this->feedbackFactory = $feedbackFactory;

        $this->client = new Client();
    }

    /**
     * @param Site $site
     */
    public function getPublicKey(Site $site):void
    {
        $rawResponse = $this->client->get($this->getSitePublicKeyUrl($site));
        $rawResponseBody = $rawResponse->getBody();
        $jsonResponse = json_decode($rawResponseBody, true);

        $adminPublicKey = $jsonResponse['public_key'] ?? '';
        $this->settSitePublicKeyInFile($site, $adminPublicKey);
    }

    /**
     * @param Site $site
     * @return string
     */
    private function getSitePublicKeyUrl(Site $site): string
    {
        return 'http://' . $site->domain_name . self::GET_SITE_PUBLIC_KEY_URL;
    }

    /**
     * @param Site $site
     * @param $key
     */
    private function settSitePublicKeyInFile(Site $site, $key): void
    {
        $fp = fopen(SecretKeyHelper::getSitePublicKeyPath($site), 'w');
        fwrite($fp, $key);
        fclose($fp);
    }

    /**
     * @param Site $site
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchFeedback(Site $site)
    {
        $time = Carbon::now()->format('D-M-Y');
        $password =  RsaEncryption::encrypt($time, SecretKeyHelper::getSitePublicKey($site));

        $response = $this->client->request('POST', $this->getFeedbackUrl($site), [
            'form_params' => [
                'password' => $password,
            ]]);
        $rawResponseBody = $response->getBody();
        $jsonResponse = json_decode($rawResponseBody, true);
        $feedbackData = $jsonResponse['data'] ?? [];

        $this->saveFeedbackData($site, $feedbackData);

    }

    /**
     * @param Site $site
     * @return string
     */
    private function getFeedbackUrl(Site $site): string
    {
        return 'http://' . $site->domain_name . self::GET_FEEDBACK_URL;
    }

    /**
     * @param Site $site
     * @param $data
     * @throws \Exception
     */
    private function saveFeedbackData(Site $site, $data)
    {
        \DB::beginTransaction();

        foreach ($data as $feedbackData) {
            $feedback = $this->feedbackFactory->createNew();

            $feedback->message = $feedbackData['message'];
            $feedback->reply_email = $feedbackData['reply_email'];
            $feedback->site_id = $site->id;
            $feedback->created_at = $feedbackData['created_at'];
            $feedback->updated_at = $feedbackData['updated_at'];

            $feedback->save();
        }

        \DB::commit();
    }
}