<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;
use Carbon\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostCase()
    {
        $response = $this->get('/posts');

        $response ->assertSeeText('No Blog post yet!');
    }

    public function testSee1PostWithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();


        // Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blogposts',[
            'title' => 'New title'
            ]);

    }

    public function testSee1PostWithComments()
    {
        // Arrange
        $user = $this->user();
        $post = $this->createDummyBlogPost();
        // factory(Comment::class, 4)->create([
        //     'blog_post_id' => $post->id
        // ]); //ovo ne radi
        Comment::factory()->count(4)->create([
            'commentable_id'=>$post->id,
            'commentable_type'=> 'App\Models\BlogPost',
            'user_id' => $user->id,
            ]);

        // Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('4 comments');

    }

    public function testStoreValid()
    {
        // Arrange
        $params = [
            'title'=>'Valid title',
            'content'=>'At leasr 10 characters'
        ];

        // Act 302 redirect
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        //Assert
        $this->assertEquals(session('status'),'Blog post was created!');

    }

    public function testStoreFail()
    {
        // Arrange
        $params = [
            'title'=>'x',
            'content'=>'x'
        ];

        // Act 302 redirect
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0],'The title must be at least 5required characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');


        // dd($messages->getMessages());

        //Assert
        // $this->assertEquals(session('status'),'Blog post was created!');

    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        // $this->assertDatabaseHas('blogposts', $post->toArray()); izbacuje error zbog created_at
        $this->assertDatabaseHas('blogposts', $post->getAttributes());

        $params = [
            'title'=>'A new named title',
            'content'=>'Content was changed'
        ];


        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was updated!');
        $this->assertDatabaseMissing('blogposts', $post->getAttributes());
        $this->assertDatabaseHas('blogposts', ['title' => 'A new named title']);

    }

    public function testDelete()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blogposts', $post->getAttributes());

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');
        // $this->assertDatabaseMissing('blogposts',$post->getAttributes());
        $this->assertSoftDeleted('blogposts', $post->getAttributes());

    }

    private function createDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title ='New title';
        // $post->content ='Content of the blog post';
        // $post->save();

        $post = BlogPost::factory()->newTitle()->create(
            [
                'user_id' => $userId ?? $this->user()-> id,
            ]
        );

        return $post;
    }

}
