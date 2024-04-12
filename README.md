# Cagnot'Potes 💰

Cagnot'Potes is a Symfony project that aims to provide a platform similar to GoFundMe, where users can create fundraising campaigns for various causes and receive donations from others.

## Screenshots 📸

![CagnotPotes-homepage-preview](https://raw.githubusercontent.com/n-ypy/ReadMeAssetsVault/main/CagnotPotes/home.png)
![CagnotPotes-homepage-preview](https://raw.githubusercontent.com/n-ypy/ReadMeAssetsVault/main/CagnotPotes/show.png)

## Installation 🛠️

To run this project locally, follow these steps:

1. Clone the repository:

   ```bash
   git clone https://github.com/n-ypy/Cagnot-Potes
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Set up the database and configure `.env` file with your database credentials.

4. Run migrations to create the database schema:

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. Start the Symfony development server:

   ```bash
   symfony server:start
   ```

6. Access the application in your web browser at `http://localhost:8000` 🌐.
