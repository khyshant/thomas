<?php
/**
 * Created by PhpStorm.
 * User: khysh
 * Date: 22/03/2020
 * Time: 21:36
 */

namespace App\Tests;


use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FunctionalTest extends WebTestCase
{
    public function testSuccessfullLogin()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, "/login");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $form = $crawler->filter('form')->form([
            "email" => "anth.blanchard@gmail.com",
            "password" => "test",
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        //$client->followRedirect();
        //$this->assertEquals('',$client->getRequest()->attributes->get('route'));
    }
/*
    public function testFailedLogin()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, "/login");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $form = $crawler->filter('form[name=login_form]')->form([
            "_username" => "user1_1",
            "_password" => "fail",
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $crawler = $client->followRedirect();
        $this->assertEquals('login',$client->getRequest()->attributes->get('_route'));
        $this->assertStringContainsString('Invalid credentials.',$crawler->filter('div.alert-danger')->text());
    }

    public function testFailedcreatUser()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, "/create-account");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $form = $crawler->filter('form[name=user]')->form([
            "user[username]" => "user1_1",
            "user[email]" => "a.a@gmail.com",
            "user[password]" => "userpass",
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testSuccesscreatUser()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, "/create-account");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=user]')->form([
            "user[username]" => "tatadu330",
            "user[email]" => "a.a@gmail.com",
            "user[password]" => "userpass",
        ]);
        $csrfToken = $form->get('user')['_token']->getValue();
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();
        $this->assertEquals('',$client->getRequest()->attributes->get('route'));
    }

    public function testSuccessmoretricks()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, "/moretricks");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testSuccessAddTrick()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'user1_1',
            'PHP_AUTH_PW'   => 'userpass',
        ]);
        $crawler = $client->request('GET','/create');
        $em = $client->getContainer()->get("doctrine.orm.entity_manager");
        $group = $em->getRepository(Group::class)->findOneBy([]);

        $form = $crawler->filter('form[name=trick]')->form();
        $csrfToken = $form->get("trick")['_token']->getValue();

        $trickData = [
            'Trick'=>[
                "_token"=>$csrfToken,
                "title"=>"test titlle",
                "description"=>"test description",
                "metatitle"=>"test metatitle",
                "metadescription"=>"test descKiption",
                "group"=>$group->getId(),
                "videos"=>array(
                    0 => array(
                        'uri'=>'http://test.test',
                    ),
                ),
            ],
            [
                "trick" => [
                    "images" => [
                        'uploadedFile'=>$this->createFile(),
                    ]
                ]
            ]
        ];

        $client->request(Request::METHOD_POST, '/create', $trickData);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

    }
*/
}