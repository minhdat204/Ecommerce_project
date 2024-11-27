<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Section 1: About
        $aboutId = DB::table('footer_sections')->insertGetId([
            'section_name' => 'about',
            'title' => null,
            'position' => 1,
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // About items
        DB::table('footer_items')->insert([
            [
                'section_id' => $aboutId,
                'content' => 'Ogani là một công ty chuyên cung cấp thực phẩm sạch......',
                'icon' => null,
                'link' => null,
                'position' => 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Social media icons
        foreach(['facebook', 'instagram', 'twitter', 'pinterest'] as $key => $social) {
            DB::table('footer_items')->insert([
                'section_id' => $aboutId,
                'content' => ucfirst($social),
                'icon' => "fa fa-{$social}",
                'link' => '#',
                'position' => $key + 2,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Section 2: Links
        $linksId = DB::table('footer_sections')->insertGetId([
            'section_name' => 'links',
            'title' => 'Useful Links',
            'position' => 2,
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Links items
        $links = [
            'Home', 'Shop', 'Blog', 'Contact',
            'Fresh Meat', 'Vegetable', 'Fruit & Nut Gifts', 'Fresh Berries'
        ];

        foreach($links as $key => $link) {
            DB::table('footer_items')->insert([
                'section_id' => $linksId,
                'content' => $link,
                'link' => '#',
                'position' => $key + 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Section 3: Contact
        $contactId = DB::table('footer_sections')->insertGetId([
            'section_name' => 'contact',
            'title' => 'Contact Us',
            'position' => 3,
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Contact items
        $contacts = [
            ['Address: 60-49 Road 11378 New York', 'fas fa-map-marker-alt'],
            ['Phone: +65 11.188.888', 'fas fa-phone'],
            ['Email: hello@colorlib.com', 'fas fa-envelope']
        ];

        foreach($contacts as $key => $contact) {
            DB::table('footer_items')->insert([
                'section_id' => $contactId,
                'content' => $contact[0],
                'icon' => $contact[1],
                'position' => $key + 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}


