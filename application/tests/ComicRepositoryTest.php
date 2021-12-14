<?php

namespace Tests;

use App\Clients\CachedClient;
use App\Clients\Client;
use App\Repositories\ComicRepository;
use App\Repositories\IComicRepository;
use PHPUnit\Framework\TestCase;

class ComicRepositoryTest extends TestCase
{
    private IComicRepository $comicRepository;

    function setUp(): void
    {
        $client = new Client('099736801919555940ca6d07b6bb444c', '993e6f1936115d09ee54c906f9648702c9c5ca7a');
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
