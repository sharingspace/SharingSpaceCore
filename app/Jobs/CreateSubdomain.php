<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSubdomain extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $subdomain, $domain;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subdomain, $domain)
    {
        $this->subdomain = $subdomain;
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new \Cloudflare\Api(config('services.cloudflare.email'), config('services.cloudflare.secret'));
        $client->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
        $dns = new \Cloudflare\Zone\Dns($client);
        if ($this->domain == 'anyshare.coop') {
            $dns->create('e0cd975ea66a6154cc1820a011e76392', 'CNAME', $this->subdomain, $this->domain, 1, true);
        } elseif ($this->domain == 'anysha.re') {

        }

        
    }
}
