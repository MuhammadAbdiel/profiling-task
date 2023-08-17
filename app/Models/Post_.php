<?php

namespace App\Models;

class Post
{
    private static $blog_posts = [
        [
            "title" => "Judul Post Pertama",
            "slug" => "judul-post-pertama",
            "author" => "Muhammad Abdiel Firjatullah",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos enim eum vel    nam facilis, voluptatibus, obcaecati,
                delectus consequuntur facere nisi illo maxime harum minus eligendi illum quod adipisci? Quod, esse. Magni neque nemo
                nesciunt est suscipit corrupti veritatis? Ipsa cumque laudantium qui adipisci eligendi sint quos alias possimus,
                repudiandae inventore assumenda nisi aut, natus omnis fugit rem recusandae deserunt! Id, maiores consectetur.
                Consequuntur voluptatem ut laborum nemo architecto eligendi, similique magnam praesentium tempore commodi tempora
                ducimus delectus quis fugit aut."
        ],
        [
            "title" => "Judul Post Kedua",
            "slug" => "judul-post-kedua",
            "author" => "Basukik Wrabada",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos enim eum vel    nam facilis, voluptatibus, obcaecati,
                delectus consequuntur facere nisi illo maxime harum minus eligendi illum quod adipisci? Quod, esse. Magni neque nemo
                nesciunt est suscipit corrupti veritatis? Ipsa cumque laudantium qui adipisci eligendi sint quos alias possimus,
                repudiandae inventore assumenda nisi aut, natus omnis fugit rem recusandae deserunt! Id, maiores consectetur.
                Consequuntur voluptatem ut laborum nemo architecto eligendi, similique magnam praesentium tempore commodi tempora
                ducimus delectus quis fugit aut. Nesciunt est suscipit corrupti veritatis? Ipsa cumque laudantium qui adipisci eligendi sint quos alias possimus,
                repudiandae inventore assumenda nisi aut, natus omnis fugit rem recusandae deserunt! Id, maiores consectetur."
        ]
    ];

    public static function all()
    {
        return collect(self::$blog_posts);
    }

    public static function find($slug)
    {
        $posts = static::all();
        return $posts->firstWhere("slug", $slug);
    }
}
