<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Services\StructuredDataService;
use App\Services\SubscriptionService;

class SubscribeController extends Controller
{
    private StructuredDataService $structuredDataService;

    private SubscriptionService $subscriptionService;

    public function __construct(
        StructuredDataService $structuredDataService,
        SubscriptionService $subscriptionService
    ) {
        $this->structuredDataService = $structuredDataService;
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(SubscribeRequest $request)
    {
        $url = $request->get('url');
        [$sku, $price] = $this->structuredDataService->readDataFromJsonLd($url);
        if (!$sku || !$price) {
            throw new \Exception("Sku or price not found");
        }
        $email = $request->get('email');
        $this->subscriptionService->subscribe($email, $url, $sku, $price);
        return response()->json(['sku' => $sku]);
    }
}
