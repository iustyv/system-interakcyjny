<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if(null===$this->manager || null===$this->faker) {
            return;
        }

        $this->createMany(100, 'tasks', function (int $i){
            $task = new Task();
            $task->setTitle($this->faker->sentence);
            $task->setCreatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $task->setUpdatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            /** @var Category $category */
            $category=$this->getRandomReference('categories');
            $task->setCategory($category);

            return $task;
        });

        $this->manager->flush();
    }

    public function getDependencies() : array
    {
        return [CategoryFixtures::class];
    }
}
