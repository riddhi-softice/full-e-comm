<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         $users = [
    [
        'name' => 'Ravi Patel',
        'email' => 'ravi@example.com',
        'password' => bcrypt('123456'),
        'phone' => '9876543210',
        'address' => '101 MG Road, Surat, Gujarat',
    ],
    [
        'name' => 'Anjali Mehta',
        'email' => 'anjali@example.com',
        'password' => bcrypt('123456'),
        'phone' => '9988776655',
        'address' => '22 LBS Marg, Mumbai, Maharashtra',
    ],
    [
        'name' => 'Amit Sharma',
        'email' => 'amit@example.com',
        'password' => bcrypt('123456'),
        'phone' => '9123456789',
        'address' => '45 Civil Lines, Jaipur, Rajasthan',
    ],
    [
        'name' => 'Neha Singh',
        'email' => 'neha@example.com',
        'password' => bcrypt('123456'),
        'phone' => '9090909090',
        'address' => '33 MG Road, Delhi',
    ],
    [
        'name' => 'Farhan Khan',
        'email' => 'farhan@example.com',
        'password' => bcrypt('123456'),
        'phone' => '9012345678',
        'address' => '11 FC Road, Pune, Maharashtra',
    ]
];

    foreach ($users as $user) {
        User::create($user);
    }



        $reviews = [
            [
                'product_id' => 3,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Absolutely stunning watch! Worth every penny.',
            ],
            [
                'product_id' => 2,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Tough and reliable. Great for outdoor use.',
            ],
            [
                'product_id' => 3,
                'user_id' => 3,
                'rating' => 3,
                'comment' => 'Good features but battery drains fast.',
            ],
            [
                'product_id' => 4,
                'user_id' => 4,
                'rating' => 5,
                'comment' => 'A true classic. Feels premium and classy.',
            ],
            [
                'product_id' => 5,
                'user_id' => 1,
                'rating' => 4,
                'comment' => 'Affordable and rugged. Strap quality could be better.',
            ],
        ];


    foreach ($reviews as $review) {
        Review::create($review);
    }
    }
}
