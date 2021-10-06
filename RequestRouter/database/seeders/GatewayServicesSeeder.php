<?php

namespace RequestRouter\database\seeders;

use Illuminate\Database\Seeder;
use RequestRouter\Model\GatewayServices;

class GatewayServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        GatewayServices::insert([
            [
                'name' => 'default',
                'doc_point' => '/docs',
                /** Can client calls the routes that are not defined here on this service */
                'just_current_routes' => true,
                'domain' => 'local',
            ],
            [
                'name' => 'fake',
                'doc_point' => 'https://jsonplaceholder.typicode.com/',
                'just_current_routes' => true,
                'domain' => 'https://jsonplaceholder.typicode.com/'
            ],
            [
                'name' => 'subscription',
                'doc_point' => 'https://staging-subscription.janex.org/docs',
                'just_current_routes' => false,
                'domain' => 'https://staging-subscription.janex.org/'
            ],
            [
                'name' => 'kyc',
                'doc_point' => 'https://staging-kyc.janex.org/docs',
                'just_current_routes' => false,
                'domain' => 'https://staging-kyc.janex.org/'
            ],
            [
                'name' => 'local_subscription',
                'doc_point' => 'http://192.168.43.121:3561/docs',
                'just_current_routes' => false,
                'domain' => 'http://192.168.43.121:3561/'
            ],
            [
                'name' => 'google',
                'doc_point' => 'https://jsonplaceholder.typicode.com/',
                'just_current_routes' => false,
                'domain' => 'https://google.com/'
            ],
        ]);

    }
}
