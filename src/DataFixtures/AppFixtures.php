<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Character;

class AppFixtures extends Fixture
{

    public function setCharacter($kind, $characterName, $characterData): Character
    {
        $character = new Character();
        $character
            ->setKind(substr_replace($kind, '', -1))
            ->setName($characterName)
            ->setSurname($characterData['surname'])
            ->setCaste($characterData['caste'])
            ->setKnowledge($characterData['knowledge'])
            ->setIntelligence($characterData['intelligence'])
            ->setLife($characterData['life'])
            ->setImage(strtolower('/images/cartes/' . $kind . '/' . $characterName . '.jpg'))
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreated(new \DateTime())
            ->setModified(new \DateTime());
        return $character;
    }

    public function load(ObjectManager $manager): void
    {
        # Creates All the Characters from json
        $characters = json_decode(file_get_contents('https://la-guilde-des-seigneurs.com/json/characters.json'), 2);
        foreach ($characters as $kind => $charactersData) {
            foreach ($charactersData as $characterName => $characterData) {
                $character = $this->setCharacter($kind, $characterName, $characterData);
                $manager->persist($character);
            }
            $manager->flush();
        }
    }
}
