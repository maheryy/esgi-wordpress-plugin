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
                    <input type="text" id="twitch_account" value="<?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='twitch_account'")
                        );

                        if (count($resultQuery)) {
                            echo json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                        }
                    ?>">
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" <?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='twitch_button_visible'")
                        );

                        if (count($resultQuery)) {
                            if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                echo 'checked';
                            }
                        }
                    ?>> Afficher le bouton "Suivre"
                    </label>
                </div> 
                <div>
                    <label>
                        <input type="checkbox" <?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='twitch_tchat_visible'")
                        );

                        if (count($resultQuery)) {
                            if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                echo 'checked';
                            }
                        }
                    ?>> Afficher le tchat
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox" <?php
                    global $wpdb;
                    
                    $resultQuery = $wpdb->get_results( 
                        $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='twitch_activated'")
                    );

                    if (count($resultQuery)) {
                        if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                            echo 'checked';
                        }
                    }
                ?>> Activer le module
            </label>
        </section>

        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Youtube</h2>
                <div style="margin-bottom: 20px;">
                    <label for="ytb_account">
                        Compte
                    </label><br>
                    <input type="text" id="ytb_account" value="<?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_account'")
                        );

                        if (count($resultQuery)) {
                            echo json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                        }
                    ?>">
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" <?php
                            global $wpdb;
                            
                            $resultQuery = $wpdb->get_results( 
                                $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_button_visible'")
                            );

                            if (count($resultQuery)) {
                                if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                    echo 'checked';
                                }
                            }
                        ?>> Afficher le bouton "S'abonner"
                    </label>
                </div> 
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" <?php
                            global $wpdb;
                            
                            $resultQuery = $wpdb->get_results( 
                                $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_likes_visible'")
                            );

                            if (count($resultQuery)) {
                                if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                    echo 'checked';
                                }
                            }
                        ?>> Afficher le nombre de vues
                    </label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox" <?php
                            global $wpdb;
                            
                            $resultQuery = $wpdb->get_results( 
                                $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_likes_visible'")
                            );

                            if (count($resultQuery)) {
                                if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                    echo 'checked';
                                }
                            }
                        ?>> Afficher le nombre de likes
                    </label>
                </div>
                <div style="margin-bottom: 20px;">
                    <label>
                        <input type="checkbox" <?php
                            global $wpdb;
                            
                            $resultQuery = $wpdb->get_results( 
                                $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_dislikes_visible'")
                            );

                            if (count($resultQuery)) {
                                if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                    echo 'checked';
                                }
                            }
                        ?>> Afficher le nombre de dislikes
                    </label>
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <select>
                            <?php
                                global $wpdb;
                                $YtbTypePosts;
                                
                                $resultQuery = $wpdb->get_results( 
                                    $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_type_videos'")
                                );

                                if (count($resultQuery)) {
                                    $YtbTypePosts = json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                                }

                                $keysValues = [
                                    'last' => 'Afficher les dernières vidéos',
                                    'moreViews' => 'Afficher les vidéos les plus vues',
                                    'moreLikes' => 'Afficher les vidéos les plus appréciées',
                                ];
                                foreach ($keysValues as $key => $value) {
                                    if ($YtbTypePosts == $key) {
                                        echo "<option value='" . $key . "' selected>" . $value . "</option>";
                                    }else {
                                        echo "<option value='" . $key . "'>" . $value . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        <select>
                            <?php
                                global $wpdb;
                                $YtbNbPosts;
                                
                                $resultQuery = $wpdb->get_results( 
                                    $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_nb_videos'")
                                );

                                if (count($resultQuery)) {
                                    $YtbNbPosts = json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                                }

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($YtbNbPosts == $i) {
                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                    }else {
                                        echo "<option value='" . $i . "'>" . $i . "</option>";
                                    }
                                }
                            ?>
                        </select> Vidéos à afficher
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox" <?php
                    global $wpdb;
                    
                    $resultQuery = $wpdb->get_results( 
                        $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_activated'")
                    );

                    if (count($resultQuery)) {
                        if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                            echo 'checked';
                        }
                    }
                ?>> Activer le module
            </label>
        </section>

        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Instagram</h2>
                <div style="margin-bottom: 20px;">
                    <label for="insta_account">
                        Compte
                    </label><br>
                    <input type="text" id="instagram_account" value="<?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_account'")
                        );

                        if (count($resultQuery)) {
                            echo json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                        }
                    ?>">
                </div>

                <div style="margin-bottom: 5px;">
                    <label><input type="checkbox" <?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_button_visible'")
                        );

                        if (count($resultQuery)) {
                            if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                echo 'checked';
                            }
                        }
                    ?>> Afficher le bouton "Follow"</label>
                </div> 
                <div style="margin-bottom: 5px;">
                    <label><input type="checkbox" <?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_description_visible'")
                        );

                        if (count($resultQuery)) {
                            if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                echo 'checked';
                            }
                        }
                    ?>> Afficher la description du post</label>
                </div>
                <div style="margin-bottom: 20px;">
                    <label><input type="checkbox" <?php
                        global $wpdb;
                        
                        $resultQuery = $wpdb->get_results( 
                            $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_likes_visible'")
                        );

                        if (count($resultQuery)) {
                            if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                                echo 'checked';
                            }
                        }
                    ?>> Afficher le nombre de likes</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <select>
                            <?php
                                global $wpdb;
                                $instaTypePosts;
                                
                                $resultQuery = $wpdb->get_results( 
                                    $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_type_posts'")
                                );

                                if (count($resultQuery)) {
                                    $instaTypePosts = json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                                }

                                $keysValues = [
                                    'last' => 'Afficher les derniers posts',
                                    'moreViews' => 'Afficher les posts les plus vus',
                                    'moreLikes' => 'Afficher les posts les plus appréciés',
                                ];
                                foreach ($keysValues as $key => $value) {
                                    if ($instaTypePosts == $key) {
                                        echo "<option value='" . $key . "' selected>" . $value . "</option>";
                                    }else {
                                        echo "<option value='" . $key . "'>" . $value . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        <select>
                            <?php
                                global $wpdb;
                                $instaNbPosts;
                                
                                $resultQuery = $wpdb->get_results( 
                                    $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_nb_posts'")
                                );

                                if (count($resultQuery)) {
                                    $instaNbPosts = json_decode(json_encode($resultQuery[0]), true)['valueKey'];
                                }

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($instaNbPosts == $i) {
                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                    }else {
                                        echo "<option value='" . $i . "'>" . $i . "</option>";
                                    }
                                }
                            ?>
                        </select> Posts à afficher
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox" <?php
                    global $wpdb;
                    
                    $resultQuery = $wpdb->get_results( 
                        $wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='instagram_activated'")
                    );

                    if (count($resultQuery)) {
                        if (json_decode(json_encode($resultQuery[0]), true)['valueKey'] === 'true') {
                            echo 'checked';
                        }
                    }
                ?>> Activer le module
            </label>
        </section>
    </div>

    <section style="margin-top: 20px;">
        <input type="submit" class="button action" value="Enregistrer">
    </section>

    <section class="notifySection">
        <?php
            if (!empty($_POST)) {
                if ($messageOk) {
                    echo "<p>Les modifications viennent d'être enregistrées.</p>";
                }else {
                    echo "<p>Une erreur est survenue, veuillez réessayer.</p>";
                }
            }
        ?>
    </section>
</form>