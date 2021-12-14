<?php

namespace Tests;

use App\Clients\CachedClient;
use App\Clients\Client;
use App\Repositories\ComicRepository;
use App\Repositories\IComicRepository;

class ComicRepositoryTest extends BaseTest
{
    private IComicRepository $comicRepository;

    function setUp(): void
    {
        $client = new Client($_ENV['MARVEL_PUBLIC_KEY'], $_ENV['MARVEL_PRIVATE_KEY']);
        $this->comicRepository = new ComicRepository(new CachedClient($client));
    }

    public function testResultsCanBeFilteredByTitle()
    {
        $results = $this->comicRepository->search('Marvel Previews (2017)', 50);
        $this->assertCount(3, $results);
    }

    public function testFullResultsCanBeRetrievedWhenTitleIsEmpty()
    {
        $results = $this->comicRepository->search('', 50);
        $this->assertCount(20, $results);
    }

    public function testResultsCanBeLimited()
    {
        $results = $this->comicRepository->search('', 6);
        $this->assertCount(6, $results);
    }

    public function testResultsCanBeSkipped()
    {
        $results = $this->comicRepository->search('', 6, 17);
        $this->assertCount(3, $results);
    }
}
