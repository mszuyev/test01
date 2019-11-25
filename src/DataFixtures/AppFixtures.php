<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\HotelChain;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadHotels($manager);
        $this->loadReviews($manager);
        $manager->flush();
    }

    public function loadHotels(ObjectManager $manager)
    {
        $hc = new HotelChain();
        $hc->setName('Hotel Alexanderplatz chain');

        $hotel = new Hotel();
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setRooms(150);
        $hotel->setChainId(1);
        $hotel->setUuid(Uuid::uuid4()->toString());

        $hc->addHotel($hotel);

        $hotel = new Hotel();
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setRooms(150);
        $hotel->setChainId(1);
        $hotel->setUuid(Uuid::uuid4()->toString());
        $hc->addHotel($hotel);

        $hotel = new Hotel();
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setRooms(150);
        $hotel->setChainId(1);
        $hotel->setUuid(Uuid::uuid4()->toString());
        $hc->addHotel($hotel);

        $hotel = new Hotel();
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setRooms(150);
        $hotel->setChainId(1);
        $hotel->setUuid(Uuid::uuid4()->toString());
        $hc->addHotel($hotel);

        $hotel = new Hotel();
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setRooms(150);
        $hotel->setChainId(1);
        $hotel->setUuid(Uuid::uuid4()->toString());

        $hc->addHotel($hotel);
        $manager->persist($hc);

        $hc = new HotelChain();
        $hc->setName('Hotel Alexanderplatz chain');

        $hotel = new Hotel();
        $hotel->setName('Another Hotel');
        $hotel->setAddress('Some test address, Berlin');
        $hotel->setRooms(10);
        $hotel->setChainId(0);
        $hotel->setUuid(Uuid::uuid4()->toString());
        $hc->addHotel($hotel);

        $manager->persist($hc);
    }

    public function loadReviews(ObjectManager $manager)
    {
        // hotel 1
        $review = new Review();
        $review->setHotelId(1);
        $review->setText('Very nice stay');
        $review->setScore(10);
        $review->setDate(new \DateTime('2015-01-01 10:08:00'));
        $manager->persist($review);

        $review = new Review();
        $review->setHotelId(1);
        $review->setText('Average');
        $review->setScore(5);
        $review->setDate(new \DateTime('2019-08-10 11:08:00'));
        $manager->persist($review);

        $review = new Review();
        $review->setHotelId(1);
        $review->setText('Very nice stay, I enjoyed it a lot.');
        $review->setScore(9);
        $review->setDate(new \DateTime('2019-08-10 11:08:00'));
        $manager->persist($review);

        $review = new Review();
        $review->setHotelId(1);
        $review->setText('Worst experience ever.');
        $review->setScore(1);
        $review->setDate(new \DateTime('2019-09-10 11:08:00'));
        $manager->persist($review);

        // hotel 2
        $review = new Review();
        $review->setHotelId(2);
        $review->setText('The receptionist was not smiling.');
        $review->setScore(5);
        $review->setDate(new \DateTime('2019-07-10 11:08:00'));
        $manager->persist($review);

        $review = new Review();
        $review->setHotelId(2);
        $review->setText('Very nice stay, the reception was really fast.');
        $review->setScore(10);
        $review->setDate(new \DateTime('2019-06-10 11:08:00'));
        $manager->persist($review);
    }
}
