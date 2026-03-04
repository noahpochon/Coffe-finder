# ☕ Coffee Tracker

**Coffee Tracker** est une application web légère et élégante développée en **PHP** permettant de localiser instantanément les cafés les plus proches dans n'importe quelle ville. 🚀



## ✨ Caractéristiques

* 🔍 **Recherche dynamique** : Trouvez des cafés par ville en un clic.
* 🗺️ **Intégration Maps** : Visualisation directe via une interface interactive.
* 🎨 **Design Moderne** : Interface épurée avec animations fluides (Zooms, Fade-in).
* 📱 **Responsive Design** : Utilisable sur ordinateur et mobile.
* 🛡️ **Respect de la vie privée** : Statistiques anonymes sans cookies via **Umami**.

## 🛠️ Technologies utilisées

* **Backend** : PHP 8.x
* **Frontend** : HTML5, CSS3 (Flexbox & Animations)
* **Fonts** : Poppins (Google Fonts)
* **Analytique** : [Umami.is](https://umami.is/)
* **Hébergement** : [Alwaysdata](https://www.alwaysdata.com/)

## 🚀 Installation locale (Linux)

Pour faire tourner ce projet sur votre machine (Ubuntu/Debian/Mint) :

1.  **Installez la pile LAMP** :
    ```bash
    sudo apt update
    sudo apt install apache2 php libapache2-mod-php
    ```

2.  **Clonez le dépôt** dans votre dossier serveur :
    ```bash
    cd /var/www/html/
    git clone [https://github.com/votre-pseudo/coffee-tracker.git](https://github.com/votre-pseudo/coffee-tracker.git)
    ```

3.  **Donnez les permissions** :
    ```bash
    sudo chown -R $USER:$USER /var/www/html/coffee-tracker/
    ```

4.  **Lancez** votre navigateur sur : `http://localhost/coffee-tracker`

## ⚖️ Mentions Légales & Confidentialité

Ce projet utilise **Umami** pour collecter des statistiques d'audience de manière totalement anonyme, sans stockage de données personnelles ni utilisation de cookies publicitaires. L'hébergement est assuré par **Alwaysdata**.

---
Développé avec ❤️ par Noah Pochon
