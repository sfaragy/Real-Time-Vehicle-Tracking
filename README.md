# Teamups Technical Exercise (back-end focus)

## Intro

Introduction video: https://drive.google.com/file/d/1KlPYZfZEVaBqDU0AbiXGgz_zmAV-Lhl3/view?usp=drive_link

Built with `create-next-app`, this is a NextJS food delivery-related app for real-time streaming.

![LMWN assessment screenshot](https://teamupsgeneral.blob.core.windows.net/teamupspublic/sr-backend-assessment/LMWN%20assessment%20screenshot%20-%20order%20tracker.png)

## Quick start

1. Clone the repo: `git clone {REPO_URL}`

2. CD into the repo: `cd /path/to/repo`

3. [Option 1: Docker] Start via docker compose: `docker-compose up` ([walkthrough video](https://drive.google.com/file/d/1KxLL6f6pW1WPBKgm6TxHHyO4Io1OAkXd/view?usp=drive_link)). [Option 2: NPM] Create a `.env` file at the root level of the repo with the following contents: "MONGODB_URI=mongodb://localhost:27017/order-tracker". Run MongoDB locally on the default port. Install dependencies: `npm install`. Start the app via `npm run dev` ([walkthrough video](https://drive.google.com/file/d/1IKbLUl06zIXee_g8XQOx15vj4tRc9F7e/view?usp=drive_link)).

4. Once running, visit `http://localhost:3000/` to load the app--the first load might be slow. You should see the following page if everything is successful.
![LMWN assessment screenshot - home](https://teamupsgeneral.blob.core.windows.net/teamupspublic/sr-backend-assessment/LMWN%20assessment%20screenshot%20-%20home.png)

5. Click on the "Create seed" button to bootstrap the drivers data once you are ready.

## Sample git workflow

Here is a sample flow for making changes and submitting a PR after completing the exercise:

```
// check out a new branch for your changes
git checkout -b {BRANCH_NAME}

// make changes and commit them
git add --all
git commit

// push new branch up to GitHub
git push origin {BRANCH_NAME}

// use GitHub to make PR
// (DO NOT MERGE PR)
```
