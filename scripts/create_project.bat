@Echo OFF
echo CREATE_PROJECT v.0.1.0.
echo.***********************
echo.

SET git_repo_name=
SET git_repo_link=
SET /p git_repo_name=[1/2] Name of the git repository : 
SET /p git_repo_link=[2/2] Link of the git repository : 
cd %~dp0../
SET path_projects=%cd%/projects
SET path_library=%cd%/src/SimFWKLib

REM # Cloning git repository
cd %path_projects%
git clone %git_repo_link%

REM # Creating .gitignore file
cd %git_repo_name%
echo .vscode/ > .gitignore
echo node_modules/ >> .gitignore
echo src/SimFWKLib >> .gitignore
echo vendor/ >> .gitignore

REM # Creating symbolic link to the SimFWK library
mkdir src
mklink /D "%path_projects%/%git_repo_name%/src/SimFWKLib" "%path_library%"

REM # Adding first commit
git add .
git add src
git commit -m "Add .gitignore file"
git push

cd ../../
pause