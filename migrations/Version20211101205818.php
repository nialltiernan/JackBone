<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101205818 extends AbstractMigration
{
    private const NAMES = [
        'People & Body (family)',
        'Smileys & Emotion (face-smiling)',
        'Smileys & Emotion (emotion)',
        'Activities (game)',
        'Smileys & Emotion (face-affection)',
        'Smileys & Emotion (face-concerned)',
        'Smileys & Emotion (face-neutral-skeptical)',
        'People & Body (hand-fingers-partial)',
        'Smileys & Emotion (face-sleepy)',
        'Symbols (other-symbol)',
        'People & Body (hand-fingers-closed)',
        'People & Body (hands)',
        'Objects (music)',
        'Smileys & Emotion (monkey-face)',
        'Smileys & Emotion (face-glasses)',
        'People & Body (body-parts)',
        'Activities (event)',
        'People & Body (person-gesture)',
        'Smileys & Emotion (face-tongue)',
        'Symbols (arrow)',
        'People & Body (hand-fingers-open)',
        'People & Body (hand-single-finger)',
        'Animals & Nature (plant-flower)',
        'Travel & Places (sky & weather)',
        'Smileys & Emotion (face-negative)',
        'Objects (light & video)',
        'Smileys & Emotion (cat-face)',
        'Smileys & Emotion (face-unwell)',
        'Symbols (av-symbol)',
        'Objects (clothing)',
        'Objects (tool)',
        'People & Body (person-activity)',
        'Symbols (geometric)',
        'Smileys & Emotion (face-costume)',
        'Food & Drink (food-prepared)',
        'Animals & Nature (plant-other)',
        'Animals & Nature (animal-bird)',
        'Travel & Places (transport-air)',
        'Symbols (warning)',
        'People & Body (hand-prop)',
        'Activities (sport)',
        'People & Body (person-fantasy)',
        'Food & Drink (drink)',
        'Travel & Places (place-map)',
        'Travel & Places (transport-water)',
        'Animals & Nature (animal-mammal)',
        'Objects (money)',
        'Food & Drink (food-sweet)',
        'Travel & Places (place-other)',
        'Objects (phone)',
        'People & Body (person-role)',
        'Activities (award-medal)',
        'Flags (country-flag)',
        'Food & Drink (dishware)',
        'Symbols (alphanum)',
        'Animals & Nature (animal-bug)',
        'Objects (musical-instrument)',
        'Food & Drink (food-fruit)',
        'Food & Drink (food-vegetable)',
        'People & Body (person)',
        'People & Body (person-symbol)',
        'Objects (other-object)',
        'Animals & Nature (animal-reptile)',
        'Animals & Nature (animal-amphibian)',
        'Travel & Places (transport-ground)',
        'Objects (book-paper)',
        'Objects (medical)',
        'Symbols (transport-sign)',
        'Animals & Nature (animal-marine)',
        'Objects (computer)',
        'Objects (writing)',
        'Objects (sound)',
        'Objects (office)',
        'People & Body (person-sport)',
        'Objects (lock)',
        'Travel & Places (place-building)',
        'Activities (arts & crafts)',
        'Objects (mail)',
        'Food & Drink (food-asian)',
        'Objects (household)',
        'Flags (flag)',
        'Travel & Places (time)',
        'Symbols (zodiac)',
        'Travel & Places (place-geographic)',
        'People & Body (person-resting)',
        'Travel & Places (place-religious)',
        'Symbols (religion)',
        'Symbols (keycap)',
        'Objects (science)',
        'Smileys & Emotion (face-hand)',
        'Travel & Places (hotel)',
        'Food & Drink (food-marine)',
        'Smileys & Emotion (face-hat)',
        'Component (skin-tone)',
        'Component (hair-style)',
        'Symbols (gender)',
        'Flags (subdivision-flag)',
    ];


    public function getDescription(): string
    {
        return 'Insert emoji categories';
    }

    public function up(Schema $schema): void
    {
        foreach (self::NAMES as $NAME) {
            $this->addSql(sprintf("INSERT INTO emoji_category (name) VALUE ('%s');", $NAME));
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM emoji_category");
    }
}
