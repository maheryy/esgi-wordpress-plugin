<?php


global $wpdb;

if (!empty($_POST)) {
    # Chargement des providers et du .env qui contient les clés api
    require __DIR__ . '/../src/providers/Youtube.php';
    loadDotEnv(__DIR__ . '/../.env');

    # Récupération de tous les champs 'key' disponible dans la bdd
    $allFields = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey LIKE '" . $_POST['action'] . "%'"), ARRAY_A);
    $data = $_POST;
    switch ($_POST['action']) {
        case 'youtube':
            # Recherche si le compte n'a pas changé
            foreach ($allFields as $row) {
                if ($row['nameKey'] === 'youtube_account' && $row['valueKey'] !== sanitize($data['youtube_account'])) {
                    $changed = true;
                    break;
                }
            }
            if ($changed) {
                if ($account = Youtube::verifyChannel(sanitize($data['youtube_account']))) {
                    $data['youtube_account_id'] = $account['id'];
                    $data['youtube_account'] = $account['name'];
                } else {
                    $error = "Le compte youtube {$data['youtube_account']} n'est pas trouvé";
                }
            }
            break;
            // case 'instagram':

            //     break;
            // case 'twitch':

            //     break;
    }

    if (!isset($error)) {
        foreach ($allFields as $row) {
            # Vérification de chaque champ POST avec les champs existant en bdd
            $newValue = !empty($data[$row['nameKey']]) ? sanitize($data[$row['nameKey']]) : 0;
            $wpdb->update("{$wpdb->prefix}panelCommunity_table", ['valueKey' => $newValue], ['nameKey' => $row['nameKey']]);
        }

        $success = "<p>Les modifications viennent d'être enregistrées.</p>";
    }
}

# Récupération de toutes les données en bdd 
$fetchAll = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}panelCommunity_table"), ARRAY_A);
$results = [];
foreach ($fetchAll as $row) {
    $results[$row['nameKey']] = $row['valueKey'];
}

// Liste des options pour les types d'affichages
$sortOptions = [
    'last' => 'Afficher les dernières vidéos',
    'moreViews' => 'Afficher les vidéos les plus vues',
    'moreLikes' => 'Afficher les vidéos les plus appréciées',
];

// Liste des options pour la limite d'affichage
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

<div class="panelCommunityContainers">
    <section class="panelCommunityContainer">
        <form method="POST" class="panelCommunityForm">
            <input type="hidden" name="action" value="youtube">
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
                        <input type="checkbox" name="youtube_views_visible" value="1" <?= $results['youtube_views_visible'] ? 'checked' : '' ?>> Afficher le nombre de vues
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

            <div class="panelCommunityAction">
                <label>
                    <input type="submit" class="button action" value="Enregistrer">
                </label>
                <label>
                    <input type="checkbox" name="youtube_activated" value="1" <?= $results['youtube_activated'] ? 'checked' : '' ?>> Activer le module
                </label>
            </div>
        </form>
    </section>

    <section class="panelCommunityContainer">
        <form method="POST" class="panelCommunityForm">
            <input type="hidden" name="action" value="twitch">
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
                        <input type="checkbox" name="twitch_chat_visible" value="1" <?= $results['twitch_chat_visible'] ? 'checked' : '' ?>> Afficher le tchat
                    </label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="twitch_allow_fullscreen" value="1" <?= $results['twitch_allow_fullscreen'] ? 'checked' : '' ?>> Permettre l'affichage en plein écran
                    </label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="twitch_autoplay" value="1" <?= $results['twitch_autoplay'] ? 'checked' : '' ?>> Lancer le live à l'arrivée sur la page
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="twitch_muted" value="1" <?= $results['twitch_muted'] ? 'checked' : '' ?>> Mettre le son en muet
                    </label>
                </div>
            </div>
            <div class="panelCommunityAction">
                <label>
                    <input type="submit" class="button action" value="Enregistrer">
                </label>
                <label>
                    <input type="checkbox" name="twitch_activated" value="1" <?= $results['twitch_activated'] ? 'checked' : '' ?>> Activer le module
                </label>
            </div>
        </form>
    </section>

    <section class="panelCommunityContainer">
        <form method="POST" class="panelCommunityForm">
            <input type="hidden" name="action" value="dailymotion">
            <div class="panelCommunityContentForm">
                <h2>Dailymotion</h2>
                <div style="margin-bottom: 20px;">
                    <label for="dailymotion_account">
                        Compte
                    </label><br>
                    <input type="text" id="dailymotion_account" name="dailymotion_account" value="<?= $results['dailymotion_account'] ?>">
                </div>


                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" name="dailymotion_button_visible" value="1" <?= $results['dailymotion_button_visible'] ? 'checked' : '' ?>> Afficher le bouton de chaîne
                    </label>
                </div>
                <div style="margin-bottom: 25px;">
                    <label>
                        <input type="checkbox" name="dailymotion_title_visible" value="1" <?= $results['dailymotion_title_visible'] ? 'checked' : '' ?>> Afficher le titre des vidéos
                    </label>
                </div>
                
                <div>
                    <label>
                        <select name="dailymotion_nb_videos">
                            <?php foreach ($maxOptions as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= $key == $results['dailymotion_nb_videos'] ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select> Vidéos à afficher
                    </label>
                </div>
            </div>
            <div class="panelCommunityAction">
                <label>
                    <input type="submit" class="button action" value="Enregistrer">
                </label>
                <label>
                    <input type="checkbox" name="dailymotion_activated" value="1" <?= $results['dailymotion_activated'] ? 'checked' : '' ?>> Activer le module
                </label>
            </div>
        </form>
    </section>
</div>
<section class="notifySection">
    <?= $success ?? $error ?? '' ?>
</section>