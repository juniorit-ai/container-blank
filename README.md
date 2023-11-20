# container-blank
ubuntu:22.04 

for local
```
git clone https://github.com/juniorit-ai/container-blank.git myproject
code myproject

# VS Code command
# Dev Containers: Reopen in Container
# Dev Containers: Rebuild Container 
# Dev Containers: Add Dev Container Configuration Files...
```

for https://github.com/codespaces
```
sudo apt update
sudo apt install gh git

gh auth status
```

https://cli.github.com/manual/gh


docker build

cd .devcontainer
docker build -t haicam/juniorit-clang:v1.0.2 . 
docker push haicam/juniorit-clang:v1.0.2
