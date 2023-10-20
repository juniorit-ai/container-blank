FROM ubuntu:22.04

ARG USERNAME=juniorit
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN apt-get update

# Create the user
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m -s /bin/bash $USERNAME \
    #
    # [Optional] Add sudo support. Omit if you don't need to install software after connecting.
    && apt-get install -y sudo \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

RUN apt-get install -y locales \
	&& localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8
ENV LANG en_US.utf8a

RUN rm -rf /var/lib/apt/lists/*

# [Optional] Set the default user. Omit if you want to keep the default as root.
USER $USERNAME
