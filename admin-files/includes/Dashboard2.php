<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin-style.css">
    <link rel="icon" href="../../images/logo.png" type="image/png">
    <title>Dashboard</title>
</head>
<body>
    <style>
        * {
            color: rgb(50, 50, 50);
        }
    </style>
    <div id='back'>
        <a href="admin-menu.php">Go back</a>
    </div>
    <div class="control">
        <button onclick="showClubForm()">Ajouter un Club</button>
        <button onclick="showClubModificationForm()">Modifier Un Club</button>
        <button onclick="showMemberModificationForm()">Modifier les Membres d'un Club</button>
        <button onclick="showApplicationsManagement()">Gérer les Demandes</button>
        <button onclick="showClubDeletionForm()">Supprimer un Club</button>
    </div>
    
    <div id="result"></div>

    <?php
    if (isset($_GET['msg'])) {
        $message = htmlspecialchars($_GET['msg']);
        echo "<div class='message'>$message</div>";
    }
    ?>

    <script>
        async function fetchItems(type, searched_club_id = 1) {
            try {
                const response = await fetch(`fetch_items.php?type=${type}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return await response.json();
            } catch (error) {
                console.error('Error fetching items:', error);
                return []; 
            }
        }

        async function showClubForm() {
            const result = document.getElementById('result');
            result.innerHTML = `
                <form action="insert2.php" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='type' value='club'>
                    <label for="clubName">Ajouter un Club</label>
                    <input type="text" required placeholder="Nom du Club" name="clubName">
                    <textarea name="clubDescription" class="desc" placeholder="Description du Club" required></textarea>
                    <textarea name="clubAchievements" class="achiev" placeholder="Accomplissements du Club"></textarea>
                    <label for="clubLogo">Ajouter un Logo (1:1) (jpg)</label>
                    <input type="file" name="clubLogo" required accept="image/jpeg">
                    <input type="submit" value="Ajouter le Club">
                </form>`;
        }

        async function showClubModificationForm() {
            const result = document.getElementById('result');
            const clubs = await fetchItems('club');
            const clubOptions = clubs.map(club => `<option value="${club.club_id}">${club.club_name}</option>`).join('');

            result.innerHTML = `
                <form action="insert2.php" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='type' value='modif-club'>
                    <label for="clubId">Modifier un Club</label>
                    <select name="clubId" required>${clubOptions}</select>
                    <input type="text" placeholder="Modifier le Nom du Club" name="newClubName">
                    <textarea name="clubDescription" class="desc" placeholder="Modifier la description"></textarea>
                    <textarea name="clubAchievements" class="achiev" placeholder="Accomplissements du Club"></textarea>
                    <label for="clubLogo">Modifier le Logo (1:1) (jpg)</label>
                    <input type="file" name="clubLogo" accept="image/jpeg">
                    <input type="submit" value="Modifier le Club">
                </form>`;
        }

        async function showMemberModificationForm() {
    const result = document.getElementById('result');
    const clubs = await fetchItems('club');
    const clubOptions = clubs.map(club => `<option value="${club.club_id}">${club.club_name}</option>`).join('');

    result.innerHTML = `
        <form action="insert2.php" method="POST">
            <input type='hidden' name='type' value='modif-member'>
            <label for="clubId">Choisir un Club</label>
            <select name="clubId" id="clubId" required onchange="updateMembers()">
                ${clubOptions}
            </select>
            <label for="memberId">Choisir un Membre du Club</label>
            <select name="memberId" id="memberId" required>
                <!-- Options will be dynamically added here -->
            </select>
            <input type="text" placeholder="Modifier le Nom du Membre" name="newMemberName">
            <label for="role">Modifier le Rôle</label>
            <select name="role" required>
                <option value="Member">Member</option>
                <option value="Leader">Leader</option>
                <option value="Founder">Founder</option>
                <option value="Founder & Leader">Founder & Leader</option>
            </select>
            <input type="text" placeholder="Modifier la Classe" name="classe">
            <input type="email" placeholder="Modifier l'Email" name="mail">
            <input type="tel" placeholder="Modifier le Téléphone" name="tel">
            <input type="submit" value="Modifier le Membre">
            <button onclick="deleteMember()">Supprimer le Membre</button>
        </form>`;

    updateMembers();
}

async function updateMembers() {
    var clubId = document.getElementById('clubId').value;
    const members = await fetchItems(`club_member`, clubId);
    console.log(members)
    const memberOptions = members.map(member => `<option value="${member.member_id}">${member.name}</option>`).join('');
    document.getElementById('memberId').innerHTML = memberOptions;
}


        async function showApplicationsManagement() {
            const result = document.getElementById('result');
            const applications = await fetchItems('application');
            const clubs = await fetchItems('club');

            const clubOptions = clubs.map(club => `<option value="${club.club_id}">${club.club_name}</option>`).join('');

            const applicationList = applications
                .filter(app => app.status === 'en attente')
                .map(app => `
                    <tr data-club="${app.club_id}">
                        <td>${app.name}</td>
                        <td>${app.classe}</td>
                        <td>${app.tel}</td>
                        <td>${app.mail}</td>
                        <td>${app.essay}</td>
                        <td>
                            <button class="accept" onclick="acceptApplication(${app.application_id})">Accepter</button>
                            <button class="reject" onclick="rejectApplication(${app.application_id})">Rejeter</button>
                        </td>
                    </tr>
                `).join('');

            result.innerHTML = `
                <div class="management-container">
                    <h2>Gérer les Demandes d'adhésion</h2>
                    <label for="club-filter">Filtrer par Club:</label>
                    <select id="club-filter" onchange="filterByClub()">
                        <option value="all">All</option>
                        ${clubOptions}
                    </select>
                    <table class="application-table">
                        <thead>
                            <tr>
                                <th>Nom et Prénom</th>
                                <th>Classe</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Essai</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="application-list">
                            ${applicationList}
                        </tbody>
                    </table>
                </div>`;
        }

        function filterByClub() {
            const selectedClub = document.getElementById('club-filter').value;
            const applications = document.querySelectorAll('#application-list tr');

            applications.forEach(app => {
                const club = app.getAttribute('data-club');
                if (selectedClub === 'all' || club === selectedClub) {
                    app.style.display = '';
                } else {
                    app.style.display = 'none';
                }
            });
        }

        async function acceptApplication(applicationId) {
            try {
                const response = await fetch('manage_applications.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=accept&application_id=${applicationId}`
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                alert(result.message);
                showApplicationsManagement(); 
            } catch (error) {
                console.error('Error accepting application:', error);
            }
        }

        async function rejectApplication(applicationId) {
            try {
                const response = await fetch('manage_applications.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=reject&application_id=${applicationId}`
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                alert(result.message);
                showApplicationsManagement(); 
            } catch (error) {
                console.error('Error rejecting application:', error);
            }
        }

        async function deleteClub() {
            const clubId = document.querySelector('select[name="clubId"]').value;
            if (confirm('Êtes-vous sûr de vouloir supprimer ce club ?')) {
                const response = await fetch('delete2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `type=club&clubId=${clubId}`
                });
                const result = await response.text();
                alert(result);
                location.reload();
            }
        }

        async function deleteMember() {
            const memberId = document.querySelector('select[name="memberId"]').value;
            if (confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')) {
                const response = await fetch('delete2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `type=member&memberId=${memberId}`
                });
                const result = await response.text();
                alert(result);
                location.reload();
            }
        }

        async function showClubDeletionForm() {
            const result = document.getElementById('result');
            const clubs = await fetchItems('club');
            const clubOptions = clubs.map(club => `<option value="${club.club_id}">${club.club_name}</option>`).join('');

            result.innerHTML = `
                <form>
                    <label for="clubId">Supprimer un Club</label>
                    <select name="clubId" required>${clubOptions}</select>
                    <button type="button" onclick="deleteClub()">Supprimer le Club</button>
                </form>`;
        }

    </script>
</body>
</html>
