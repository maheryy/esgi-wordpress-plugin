<?php
global $wpdb;

$fetchAll = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}panelCommunity_table"), ARRAY_A);
$results = [];
foreach ($fetchAll as $row) {
    $results[$row['nameKey']] = $row['valueKey'];
}

$sortOptions = [
    'last' => 'Afficher les dernières vidéos',
    'moreViews' => 'Afficher les vidéos les plus vues',
    'moreLikes' => 'Afficher les vidéos les plus appréciées',
];

$maxOptions = [
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
];

?>

<h1>Panel Community</h1>

<p>Vous pouvez ici ajouter vos comptes et gérer les affichages de votre panneau de communauté.</p>

<form method="POST" class="panelCommunityForm">
    <div class="panelCommunityContainers">
        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Twitch</h2>
                <div style="margin-bottom: 20px;">
                    <label for="twitch_account">
                        Compte
                    </label>
                    <input type="text" id="twitch_account" name="twitch_account" value="<?= $results['twitch_account'] ?>">
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="twitch_button_visible" value="1" <?= $results['twitch_tchat_visible'] ? 'checked' : '' ?>> Afficher le bouton "Suivre"
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="twitch_tchat_visible" value="1" <?= $results['twitch_tchat_visible'] ? 'checked' : '' ?>> Afficher le tchat
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox" name="twitch_activated" value="1" <?= $results['twitch_activated'] ? 'checked' : '' ?>> Activer le module
            </label>
        </section>

        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Youtube</h2>
                <div style="margin-bottom: 20px;">
                    <label for="ytb_account">
                        Compte
                    </label><br>
                    <input type="text" id="ytb_account" name="youtube_account" value="<?= $results['youtube_account'] ?>">
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="youtube_button_visible" value="1" <?= $results['youtube_button_visible'] ? 'checked' : '' ?>> Afficher le bouton "S'abonner"
                    </label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="youtube_likes_visible" value="1" <?= $results['youtube_likes_visible'] ? 'checked' : '' ?>> Afficher le nombre de vues
                    </label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="youtube_likes_visible" value="1" <?= $results['youtube_likes_visible'] ? 'checked' : '' ?>> Afficher le nombre de likes
                    </label>
                </div>
                <div style="margin-bottom: 20px;">
                    <label>
                        <input type="checkbox" name="youtube_dislikes_visible" value="1" <?= $results['youtube_dislikes_visible'] ? 'checked' : '' ?>> Afficher le nombre de dislikes
                    </label>
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <select name="youtube_type_videos">
                            <?php foreach ($sortOptions as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= $key == $results['youtube_type_videos'] ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        <select name="youtube_nb_videos">
                            <?php foreach ($maxOptions as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= $key == $results['youtube_nb_videos'] ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select> Vidéos à afficher
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox" name="youtube_activated" value="1" <?= $results['youtube_activated'] ? 'checked' : '' ?>> Activer le module
            </label>
        </section>

        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Instagram</h2>
                <div style="margin-bottom: 20px;">
                    <label for="insta_account">
                        Compte
                    </label><br>
                    <input type="text" id="instagram_account" name="instagram_account" value="<?= $results['instagram_account'] ?>">
                </div>

                <div style="margin-bottom: 5px;">
                    <label><input type="checkbox" name="instagram_button_visible" value="1" <?= $results['instagram_button_visible'] ? 'checked' : '' ?>> Afficher le bouton "Follow"</label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label><input type="checkbox" name="instagram_description_visible" value="1" <?= $results['instagram_description_visible'] ? 'checked' : '' ?>> Afficher la description du post</label>
                </div>
                <div style="margin-bottom: 20px;">
                    <label><input type="checkbox" name="instagram_likes_visible" value="1" <?= $results['instagram_likes_visible'] ? 'checked' : '' ?>> Afficher le nombre de likes</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <select name="instagram_type_posts">
                            <?php foreach ($sortOptions as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= $key == $results['instagram_type_posts'] ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        <select name="instagram_nb_posts">
                            <?php foreach ($maxOptions as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= $key == $results['instagram_nb_posts'] ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select> Posts à afficher
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox" name="instagram_activated" value="1" <?= $results['instagram_activated'] ? 'checked' : '' ?>> Activer le module
            </label>
        </section>
    </div>

    <section style="margin-top: 20px;">
        <input type="submit" class="button action" value="Enregistrer">
    </section>

    <section class="notifySection">
        <?php
        if (!empty($_POST)) {
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';

            if ($messageOk) {
                echo "<p>Les modifications viennent d'être enregistrées.</p>";
            } else {
                echo "<p>Une erreur est survenue, veuillez réessayer.</p>";
            }
        }
        ?>
    </section>
</form>