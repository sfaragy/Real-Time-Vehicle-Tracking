# Base Instruction:
1.For backend please follow the instruction in README.md file in the directory: Server

2. A basic frontend will interact with the realtime backend.
   
3. Main goal was to run the realtime dirver and food delivery tracking system. Which accomplished with minimal test cover. This system will run in docker container.

## Need to make sure the git branch is "lmw-exercise-sf-logics". Because it contains all updates
Run this command after clone the repository```git checkout lmw-exercise-sf-logics```

## How to run the frontend?:
1. Clone the repository. and CD into repository root directory
2. Run this command ```git checkout lmw-exercise-sf-logics```
3. Run the command in root Dirtectory to build the frontend nextjs 14 app: ``` docker-compose up --build ```
4. Run frontend: ``` docker-compose up -d ```
5. Frontend will run in: http://localhost:3000


## How to run the backend?:
1. Change the directory to server ```cd server```
2. Run the command to build the Larvel based realtime backend: ``` docker-compose up --build ```
3. Run Realtime backend: ``` docker-compose up -d ```  or follow the instruction inside the directory <b>server<b>
4. Backend will run in: http://lmw.local.com or http://localhost
5. (Project will run smoothly in ubuntu / linux but need little pro knoledge to run in MacOS or Windows)
6. A linux user with dependent package already install can run the Make command in Makefile.

   Note: for backend please makesure that you have created the database before you run the project. Database container also running that can be easily access visa CLI or tools like DbEaver / MySQL workbench. 





## ----- Root project was a test for a senior position and the responsibility to ensure a realtime backend system + integrate with frontend ------
## Intro -- from main project ----

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
