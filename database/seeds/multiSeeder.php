<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;



use App\User;

use App\Discipline;

use App\Sub_Discipline;

use App\Academic_level;

use App\Format;

use App\Settings;

use App\Assignment_type;

class multiSeeder extends Seeder
{
    protected $_time;

    public function __construct(){
        $this->_time = \Carbon\Carbon::now();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$time = \Carbon\Carbon::now()->toDateTimeString();

        //factory(App\User::class,500)->create();

        $faker = Faker\Factory::create();

        for($i = 0; $i <= 500; $i++){
            User::insert([
                'name' => $faker->name,
                'username' => $faker->unique()->username,
                'email' => $faker->unique()->safeEmail,
                'user_type' => 'WRITER',
                'active' => 1,
                'balance' => 0,
                'orders_complete' => rand(0, 150),
                'password' => bcrypt('writer'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'last_seen'  => \Carbon\Carbon::now(),
            ]);
        }

        $users = [
        	[
        		'name' => 'Writer',
        		'username' => 'writer',
        		'email' => 'writer@gmail.com',
                'user_type' => 'WRITER',
                'active' => 1,
        		'balance' => 0,
        		'password' => bcrypt('writer'),
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'Client',
        		'username' => 'client',
        		'email' => 'client@gmail.com',
        		'user_type' => 'CLIENT',
                'active' => 1,
                'balance' => 5000,
        		'password' => bcrypt('client'),
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        ];

        $admin = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'user_type' => 'ADMIN',
                'is_admin' => '1',
                'password' => bcrypt('administrator'),
                'created_at' => $time,
                'updated_at' => $time,
            ],
        ];

        User::insert($users);

        User::insert($admin);

        $disciplines = [
        	[
        		'name' => 'Formal and Natural Sciences',
                'slug' => str_slug('Formal and Natural Sciences'),
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'Social Sciences',
                'slug' => str_slug('Social Sciences'),
        		'created_at' => $time,
        		'updated_at' => $time,
        	],
        	
        	[
        		'name' => 'Humanities',
                'slug' => str_slug('Humanities'),
        		'created_at' => $time,
        		'updated_at' => $time,
        	],
        	
        	[
        		'name' => 'Other',
                'slug' => str_slug('Other'),
        		'created_at' => $time,
        		'updated_at' => $time,
        	],
        ];

        Discipline::insert($disciplines);


        $sub_disciplines = [
            [
                'name'=> 'Astronomy',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Astronomy'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],


            [
                'name'=> 'Computer Science',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Computer Science'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],


            [
                'name'=> 'Mathematics',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Mathematics'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Biology',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Biology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Chemistry',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Chemistry'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Physics',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Physics'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Statistics',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Statistics'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Environmental Sciences',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Environmental Sciences'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Geology',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Geology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Information Technology',
                'discipline' => str_slug('Formal and Natural Sciences'),
                'slug' => str_slug('Information Technology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],


            [
                'name'=> 'Economics',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Economics'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Geography',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Geography'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Psychology',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Psychology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Sociology',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Sociology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Anthropology',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Anthropology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Archaeology',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Archaeology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Cultural Studies',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Cultural Studies'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Finance',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Finance'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Politics',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Politics'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Social Work',
                'discipline' => str_slug('Social Sciences'),
                'slug' => str_slug('Social Work'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Religion',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Religion'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Arts',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Arts'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Education',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Education'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'English Language',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('English Language'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Human Rights',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Human Rights'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Linguistics',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Linguistics'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Literature',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Literature'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Music',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Music'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'History',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('History'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Philosophy',
                'discipline' => str_slug('Humanities'),
                'slug' => str_slug('Philosophy'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Law',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Law'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Marketing',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Marketing'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Public Relations',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Public Relations'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Engineering',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Engineering'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Accounting',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Accounting'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Architecture',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Architecture'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Banking',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Banking'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Business',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Business'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Childcare',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Childcare'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Communication',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Communication'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Construction',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Construction'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Criminology',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Criminology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Employment',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Employment'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Fashion',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Fashion'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Film Studies',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Film Studies'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Health',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Health'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Journalism',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Journalism'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],


            [
                'name'=> 'Management',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Management'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],
            

            [
                'name'=> 'Media',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Media'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Medical',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Medical'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Nursing',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Nursing'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Physical Education',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Physical Education'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Project Management',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Project Management'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Sports',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Sports'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Technology',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Technology'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Tourism',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Tourism'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],

            [
                'name'=> 'Other',
                'discipline' => str_slug('Other'),
                'slug' => str_slug('Other'),
                'created_at' => $this->_time,
                'updated_at' => $this->_time,
            ],
        ];

        Sub_Discipline::insert($sub_disciplines);

        $academic_levels = [
        	[
        		'name' => 'High School',
        		'created_at' => $time,
        		'updated_at' => $time,

        	],
        	
        	[
        		'name' => 'Undergraduate/Bachelor',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],
        	
        	[
        		'name' => 'Masters',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],
        	
        	[
        		'name' => 'PHD',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],
        ];

        Academic_level::insert($academic_levels);

        $formats = [
        	[
        		'name' => 'AMA',
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name' => 'APA',
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name' => 'ASA',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'CBE',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'MLA',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'Chicago/Turabian',
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name' => 'Oxford',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'McGill Guide',
        		'created_at' => $time,
        		'updated_at' => $time,
        	],

        	[
        		'name' => 'Other',
        		'created_at' => $time,
        		'updated_at' => $time,

        	],
        ];

        Format::insert($formats);

        $assignment_types = [
        	[
                'name'=> 'Essay',
                'price'=> 12,
        		'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Admission / Scholarship Essay',
                'price'=> 12,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Research paper',
                'price'=> 10,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Research Proposal',
                'price'=> 10,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Coursework',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Term paper',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Article',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Literature / Movie review',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Report',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Dissertation',
                'price'=> 10,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Thesis',
                'price'=> 18,
                'min_duration'=> 24,
        		'created_at' => $time,
        		'updated_at' => $time,


        	],

        	[
        		'name'=> 'Thesis Proposal',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Creative writing',
                'price'=> 12,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Business plan',
                'price'=> 16,
                'min_duration'=> 24,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Speech / Presentation',
                'price'=> 12,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Outline',
                'price'=> 12,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Annotated Bibliography',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Dissertation Proposal',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Proofreading',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Paraphrasing',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Powerpoint Presentation',
                'price'=> 14,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Personal Statement',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Non-word Assignment',
                'price'=> 10,
                'min_duration'=> 10,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Math Assignment',
                'price'=> 18,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Lab Report',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Code',
                'price'=> 16,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Case Study',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        	[
        		'name'=> 'Other type',
                'price'=> 14,
                'min_duration'=> 12,
        		'created_at' => $time,
        		'updated_at' => $time,

        	],

        ];

        Assignment_type::insert($assignment_types);

        $settings = [
            [
                'name' => 'commission_percent',
                'value' => '18',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'mature_duration',
                'value' => '20',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'paypal_email',
                'value' => '18',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'account_balance',
                'value' => '0.00',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'minimum_threshold',
                'value' => '20.00',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'support_email',
                'value' => 'dismuskiplimo@gmail.com',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'notification_email',
                'value' => 'dismuskiplimo@gmail.com',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            [
                'name' => 'phone_number',
                'value' => '0720052568',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            
        ];

        Settings::insert($settings);

    }
}
