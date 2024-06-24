<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_website_endpoint_returns_json(): void
    {
        $categories = Category::factory(2)->create();

        Website::factory(10)->create()->each(function ($website) use ($categories) {
            $website->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        $response = $this->get(route('website.index'));

        $data = [
            'website' => [
                'current_page',
                'data' => [
                    'id',
                    'name',
                    'url',
                    'votes_count',
                    'categories'
                ],
            ],
        ];
        $response->assertJsonStructure($data);
    }
}
