<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteSubdomain extends Job implements ShouldQueue
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

        $banned = ['www', 'email', 'assets'];

        if (!in_array($banned, strtolower($this->subdomain))) {
            if ($this->domain == 'anyshare.coop') {
                $zone = 'e0cd975ea66a6154cc1820a011e76392';
                $id = $dns->list_records($zone, 'CNAME', $this->subdomain.'.'.$this->domain)->result[0]->id;
                $dns->delete_record($zone, $id);
            } elseif ($this->domain == 'anysha.re') {

            }
        }
        
    }
}
