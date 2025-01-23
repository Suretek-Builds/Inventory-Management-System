## Inventory Management

### Getting Started

#### Step 1 – Cloning Repository

To clone repository, use the command below:

```shell
git clone <path_to_this_repo> <your_local_dir>
```

After cloning, navigate to repository and execute `git checkout staging`
to ensure you have the latest updates.

#### Step 2 – Creating .env file

Make a copy of `.env.example` and give it name `.env`:

```shell
cp .env.example .env
```

Feel free to make any necessary changes, such as adding missing values (credentials) for external services or
modifying the ports used for forwarding from containers to the host machine (e.g., ports for pgsql or the minio).


#### Install Composer Dependencies

```bash
composer install
```

#### Generate Application Key

```bash
php artisan key:generate
```

#### Migrate Database

```bash
php artisan migrate
```

#### Run Seeder

```bash
php artisan db:seed
```

#### Install Node Dependencies

```bash
npm install or yarn install

npm run dev or yarn dev
```
#### Production

```bash
npm run build or yarn build
```
