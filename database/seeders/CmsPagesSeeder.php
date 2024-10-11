<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CmsPage::create([
            'title'=>'About Us',
            'description'=>'Content is coming soon',
            'url'=>'about-us',
            'meta-title'=>'About Us',
            'meta_description'=>'About Us Content',
            'meta_keywords'=>'about us',
            'status'=>1
        ]);
        CmsPage::create([
            'title'=>'Contact Us',
            'description'=>'Content is coming soon',
            'url'=>'contact-us',
            'meta-title'=>'Contact Us',
            'meta_description'=>'Contact Us Content',
            'meta_keywords'=>'contact us',
            'status'=>1
        ]);
        CmsPage::create([
            'title'=>'Terms & Conditions',
            'description'=>'Content is coming soon',
            'url'=>'terms-conditions',
            'meta-title'=>'Terms & Conditions',
            'meta_description'=>'Terms & Conditions Content',
            'meta_keywords'=>'terms conditions',
            'status'=>1
        ]);
        CmsPage::create([
            'title'=>'Terms & Conditions',
            'description'=>'Content is coming soon',
            'url'=>'terms-conditions',
            'meta-title'=>'Terms & Conditions',
            'meta_description'=>'Terms & Conditions Content',
            'meta_keywords'=>'terms conditions',
            'status'=>1
        ]);
    }
}
