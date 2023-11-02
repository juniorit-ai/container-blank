FROM ubuntu:22.04

ARG JUNIORIT_DEV_VER=2023102801

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

RUN rm -rf /var/lib/apt/lists/*

ENV JUNIORIT_DEV_VER $JUNIORIT_DEV_VER
COPY juniorit /usr/local/bin/juniorit
COPY jcscript /usr/local/bin/jcscript
COPY completion /etc/bash_completion

# [Optional] Set the default user. Omit if you want to keep the default as root.
USER $USERNAME
