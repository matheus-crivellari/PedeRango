# Utilizando o *Cordova* para *buildar* um *app* ***Android***

## O que é Cordova?

**Apache Cordova** é um *framework* para desenvolvimento de aplicativos *mobile*.

Permite que programadores construam aplicações para dispositivos móveis utilizando ***CSS3***, ***HTML5***, e ***JavaScript*** ao invés de depender de linguagens específicas de cada plataforma (ex.: desenvolver *iOS* usando *Objective C* ou *Swift*).

## Requisitos

- ***JDK*** (*Kit* de Desenvolvimento *Java*);
- **Android *SDK*** (*Kit* de Desenvolvimento *Android*);
- ***NodeJS***;
- ***NPM*** (Gerenciador de pacotes do *NodeJS*);
- ***Cordova***;

## Instalação

### Linux (*Ubuntu*)

1. Instale o *Java*:

        sudo apt install default-jre

2. Instale o Android *SDK*:

        sudo apt install android-sdk;
        echo $ANDROID_HOME;

3. Se o caminho da pasta não aparecer na variável `ANDROID_HOME`, configure-a manualmente da seguinte forma:

        cd /etc/profile.d # Navegue a até a pasta
        sudo nano ~/.bashrc # Edite o arquivo .bashrc

4. Dentro do arquivo cole as seguintes linhas:

        export ANDROID_HOME="/usr/lib/android-sdk"
        export PATH=$PATH:$ANDROID_HOME/tools/bin
        export PATH=$PATH:$ANDROID_HOME/platform-tools

5. Faça o download das ferramentas de *SDK*:

        wget https://dl.google.com/android/repository/sdk-tools-linux-4333796.zip

   - <small>Documentação em: https://developer.android.com/studio/command-line#top_of_page , *visualizada em* ***30/03/2019***.</small>

6. Descompacte o arquivo usando o utilitário `unzip`:

        unzip sdk-tools-linux-4333796.zip

7. Substitua a pasta `/usr/lib/android-sdk/tools` pela nova pasta `tools` contida no `.zip` baixado no passo anterior;

8. Instale o SDK desejado para a versão correta de android:

        sdkmanager "platform-tools" "platforms;android-<XX>"

   - <small>Substitua `<XX>` pelo [nível de API desejado](https://en.wikipedia.org/wiki/Android_version_history#Code_names);</small>

10. Instale o *NodeJS*:

        sudo apt install nodejs

11. Instale o *NPM*:

        sudo apt install npm

12. Instale o *Cordova* (global):

        sudo npm i -g cordova