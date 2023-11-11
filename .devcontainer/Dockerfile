FROM ubuntu:22.04

ARG JUNIORIT_DEV_VER=2023110202

ARG USERNAME=juniorit
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN apt update

# Create the user
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m -s /bin/bash $USERNAME \
    #
    # [Optional] Add sudo support. Omit if you don't need to install software after connecting.
    && apt install -y sudo \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

RUN apt install -y ca-certificates locales locales-all
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends tzdata git build-essential php-cli wget curl cmake python3 python3-pip vim zip unzip telnet net-tools

#RUN rm -rf /var/lib/apt/lists/*

ENV JUNIORIT_DEV_VER $JUNIORIT_DEV_VER
COPY juniorit /usr/local/bin/juniorit
COPY jcscript /usr/local/bin/jcscript
COPY jcode /usr/local/bin/jcode
COPY jfiles /usr/local/bin/jfiles
COPY files-router.php /usr/local/bin/files-router.php
COPY completion /etc/bash_completion

COPY php.ini /usr/local/etc/php.ini
ENV PHP_INI_SCAN_DIR /usr/local/etc

WORKDIR /home/$USERNAME/workspace

COPY .vscode /home/$USERNAME/workspace/.vscode

RUN chown -R $USERNAME:$USERNAME /home/$USERNAME/workspace

USER $USERNAME

#ENV NVM_DIR /home/$USERNAME/.nvm
#ENV NODE_VERSION 18.18.2
#RUN wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash \  
#    && . $NVM_DIR/nvm.sh \
#    && nvm install $NODE_VERSION \
#    && nvm alias default $NODE_VERSION \
#    && nvm use default

RUN cd /home/$USERNAME \
    && git clone https://github.com/emscripten-core/emsdk.git \
    && cd emsdk \
    && ./emsdk install latest \
    && ./emsdk activate latest \
    && ./upstream/emscripten/embuilder build sdl2 sdl2_image \
    && echo 'source "/home/juniorit/emsdk/emsdk_env.sh"' >> /home/$USERNAME/.bash_profile

ENTRYPOINT sleep infinity