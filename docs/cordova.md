# Utilizando o *Cordova* para *buildar* um *app* ***Android***

## O que é Cordova?

**Apache Cordova** é um *framework* para desenvolvimento de aplicativos *mobile*.

Permite que programadores construam aplicações para dispositivos móveis utilizando ***CSS3***, ***HTML5***, e ***JavaScript*** ao invés de depender de linguagens específicas de cada plataforma (ex.: desenvolver *iOS* usando *Objective C* ou *Swift*).

## Requisitos

- JDK (Kit de Desenvolvimento Java);
- Android SDK (Kit de Desenvolvimento Android);
- NodeJS;
- NPM (Gerenciador de pacotes do NodeJS);
- Cordova;

## Instalação

### Linux (Ubuntu e derivados)

1. Instale o Java

        sudo apt install default-jre

2. Instale o Android SDK

        sudo apt install android-sdk;
        echo $ANDROID_HOME;

3. Se o caminho da pasta não aparecer na variável `ANDROID_HOME`, configure-a manualmente da seguinte forma:

        cd /etc/profile.d # Navegue a até a pasta
        sudo nano meu_shell.sh # Crie um arquivo do tipo shell script (extensão .sh)

4. Dentro do arquivo recém criado cole as seguintes linhas:

        export ANDROID_HOME=''
        export

4. Instale o NodeJS

        sudo apt install nodejs

5. Instale o NPM

        sudo apt install npm

6. Instale o Cordova (globalmente)

        sudo npm i -g cordova