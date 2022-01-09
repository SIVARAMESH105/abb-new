<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],
		
		'uploads' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
        ],
		
		'flyer' => [	#Custom disc added for manage flyes module
            'driver' => 'local',
            'root' => public_path('uploads/pdf/flyers'),
            'url' => env('APP_URL').'/uploads/pdf/flyers',
        ],
		
		'main' => [	#Custom disc added for manage product module
            'driver' => 'local',
            'root' => public_path('uploads/images/products/main'),
            'url' => env('APP_URL').'/uploads/images/products/main',
        ],
		
		'thumbnail' => [	#Custom disc added for manage product module
            'driver' => 'local',
            'root' => public_path('uploads/images/products/thumbnail'),
            'url' => env('APP_URL').'/uploads/images/products/thumbnail',
        ],
		
		'ckeditor' => [	#Custom disc added for ckeditor
            'driver' => 'local',
            'root' => public_path('uploads\images\cms\ckediter_images'),
            'url' => env('APP_URL').'/uploads/images/cms/ckediter_images',
        ],
		
		'cms' => [	#Custom disc added for ckeditor
            'driver' => 'local',
            'root' => public_path('uploads\images\cms'),
            'url' => env('APP_URL').'/uploads/images/cms',
        ],
		
		'staffbios' => [	#Custom disc added for staffbios
            'driver' => 'local',
            'root' => public_path('uploads/images/staffbios'),
            'url' => env('APP_URL').'/uploads/images/staffbios/',
        ],
		
		'staffbiosThumb' => [	#Custom disc added for staffbios
            'driver' => 'local',
            'root' => public_path('uploads/images/staffbios/thumb'),
            'url' => env('APP_URL').'/uploads/images/staffbios/thumb/',
            
        ],
		
		'sitemap' => [
            'driver' => 'local',
            'root' => public_path(),
        ],
		
		'videos' => [	#Custom disc added for videos
            'driver' => 'local',
            'root' => public_path('uploads/videos'),
            'url' => env('APP_URL').'/uploads/videos/',
        ],
		
		'videoPosters' => [	#Custom disc added for videoPosters
            'driver' => 'local',
            'root' => public_path('uploads/videos/posters'),
            'url' => env('APP_URL').'/uploads/videos/posters/',
        ],

        'videoTranscript' => [ #Custom disc added for transcriptVideo
            'driver' => 'local',
            'root' => public_path('uploads/videos/transcript'),
            'url' => env('APP_URL').'/uploads/videos/transcript/',
        ],


    ],

];
