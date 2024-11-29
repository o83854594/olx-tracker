<?php

namespace App\Console\Commands;

use App\Jobs\PriceChangeNotification;
use App\Models\Advert;
use App\Services\StructuredDataService;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;

class PriceChangeTracking extends Command
{
    private StructuredDataService $structuredDataService;

    public function __construct(
        StructuredDataService $structuredDataService
    ) {
        parent::__construct();
        $this->structuredDataService = $structuredDataService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:price-change-tracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        foreach (Advert::get() as $advert) {
            [$sku, $price] = $this->structuredDataService->readDataFromJsonLd($advert->url);
            if ($price != $advert->price) {
                $advert->previous_price = $advert->price;
                $advert->price = $price;
                $advert->save();
                echo "Price changed from $advert->previous_price to $advert->price \n";
                PriceChangeNotification::dispatch($advert);
            }
        }
    }
}
