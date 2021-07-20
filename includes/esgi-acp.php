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
                    <input type="text" id="twitch_account">
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox"> Afficher le bouton "Suivre"
                    </label>
                </div> 
                <div>
                    <label>
                        <input type="checkbox"> Afficher le tchat
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox"> Activer le module
            </label>
        </section>

        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Youtube</h2>
                <div style="margin-bottom: 20px;">
                    <label for="ytb_account">
                        Compte
                    </label><br>
                    <input type="text" id="ytb_account">
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox"> Afficher le bouton "S'abonner"
                    </label>
                </div> 
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox"> Afficher le nombre de vues
                    </label>
                </div>
                <div style="margin-bottom: 5px;">
                    <label>
                        <input type="checkbox"> Afficher le nombre de likes
                    </label>
                </div>
                <div style="margin-bottom: 20px;">
                    <label>
                        <input type="checkbox"> Afficher le nombre de dislikes
                    </label>
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <select>
                            <option>Afficher les dernières vidéos</option>
                            <option>Afficher les vidéos les plus vues</option>
                            <option>Afficher les vidéos les plus appréciées</option>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        <select>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select> Vidéos à afficher
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox"> Activer le module
            </label>
        </section>

        <section class="panelCommunityContainer">
            <div class="panelCommunityContentForm">
                <h2>Instagram</h2>
                <div style="margin-bottom: 20px;">
                    <label for="insta_account">
                        Compte
                    </label><br>
                    <input type="text" id="insta_account">
                </div>

                <div style="margin-bottom: 5px;">
                    <label><input type="checkbox"> Afficher le bouton "Follow"</label>
                </div> 
                <div style="margin-bottom: 5px;">
                    <label><input type="checkbox"> Afficher la description du post</label>
                </div>
                <div style="margin-bottom: 20px;">
                    <label><input type="checkbox"> Afficher le nombre de likes</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <label>
                        <select>
                            <option>Afficher les derniers posts</option>
                            <option>Afficher les posts les plus vues</option>
                            <option>Afficher les posts les plus appréciées</option>
                        </select>
                    </label>
                </div>
                <div>
                    <label>
                        <select>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select> Posts à afficher
                    </label>
                </div>
            </div>

            <label class="activateContainer">
                <input type="checkbox"> Activer le module
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