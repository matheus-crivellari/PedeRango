# Utilizando o *Cordova* para *buildar* um *app* ***Android***

## O que é Cordova?

**Apache Cordova** é um *framework* para desenvolvimento de aplicativos *mobile*.

Permite que programadores construam aplicações para dispositivos móveis utilizando ***CSS3***, ***HTML5***, e ***JavaScript*** ao invés de depender de linguagens específicas para cada plataforma (ex.: desenvolver *iOS* usando *Objective C* ou *Swift*).

## Requisitos

- ***JDK*** (*Kit* de Desenvolvimento *Java*);
- **Android *SDK*** (*Kit* de Desenvolvimento *Android*);
- ***NodeJS***;
- ***NPM*** (Gerenciador de pacotes do *NodeJS*);
- ***Cordova***;

## Instalação

### *Linux* (*Ubuntu*)

1. Instale o *Java* a partir do **repositório oficial**:


        sudo add-apt-repository ppa:webupd8team/java
        sudo apt-get update
        sudo apt-get install oracle-java8-installer
        sudo apt install oracle-java8-set-default
        java -version

2. Baixe e descompacte o *Android Tools* no local correto:

    - <small>Documentação em: https://developer.android.com/studio/command-line , *visualizada em* ***30/03/2019***.</small>

            cd ~
            wget https://dl.google.com/android/repository/sdk-tools-linux-4333796.zip
            unzip sdk-tools-linux-4333796.zip .
            mkdir android-sdk
            mv tools android-sdk

3. Modifique seu arquivo `.bashrc`:

        cd ~
        sudo nano .bashrc

    - E adicione as seguintes linhas:

            export ANDROID_HOME=$HOME/android-sdk
            export PATH=$PATH:$ANDROID_HOME/tools/bin
            export PATH=$PATH:$ANDROID_HOME/platform-tools
            export JAVA_OPTS='-XX:+IgnoreUnrecognizedVMOptions --add-modules java.se.ee'

    - Em seguida recarregue o arquivo `.bashrc` para efetivar as modificações no *terminal*:

    - Utilize o comando `sdkmanager -- list` para verificar a funciondalidade do *SDK Manager*:

            source ~/.bashrc
            sdkmanager --list

4. Instale o SDK desejado para a versão correta de android:

    - <small>Substitua `28` pelo [nível de API desejado](https://source.android.com/setup/start/build-numbers);</small>

            sdkmanager "platform-tools" "platforms;android-28"
            sdkmanager "build-tools;28.0.3"

5. Verifique se o `curl` está instalado, se não estiver, isntale-o:

        curl -v
        sudo apt install curl

6. Instale o *Gradle* utilizando o **gerenciador de pacotes** do *Java*, **SDKMan**:

        curl -s "https://get.sdkman.io" | bash
        source "$HOME/.sdkman/bin/sdkman-init.sh"
        sdk version
        sdk install gradle 5.3.1
        gradle -v

7. Instlae o *NodeJS* a partir do **repositório oficial**:

        curl -sL https://deb.nodesource.com/setup_11.x | sudo -E bash -
        sudo apt-get install -y nodejs
        node -v
        npm -v

8. Instale o *Cordova* (*globalmente*: `-g`):

        sudo npm i -g cordova
        cordova -v

---

### *Windows*
1. Instale o [*Java*](https://www.oracle.com/technetwork/java/javase/downloads/jdk8-downloads-2133151.html) do site oficial da **Oracle**;

    - <small>*Visitado em* ***30/03/2019***.</small>;

2. Instale o [*Android Studio*](https://developer.android.com/studio/install) do site oficial do **Android Developer**;

3. Se necessário, baixe e descompacte o [*Android Tools*](https://dl.google.com/android/repository/sdk-tools-linux-4333796.zip) no local correto;

    - <small>Documentação em: https://developer.android.com/studio/command-line , *visualizada em* ***30/03/2019***.</small>;

4. Instale o [*NodeJS*](https://nodejs.org/en/download/) do site oficial do NodeJS;

    - <small>Dê preferência para a versão *LTS* (*Long Term Support*)</small>;
    - <small>Atenção à versão do seu sistema operacional (*x86* ou *x64*)</small>;

5. Abra uma instância do *cmd* com **permissões de administrador** e execute o seguinte comando:

        node -v

    - Se a versão instalada do `node` for exibida no console então a instalação está *ok*;

6. Instale o *Cordova* (*globalmente*: `-g`):

        npm i -g cordova
        cordova -v

---

## Criando um projeto *Cordova*

Os passos à seguir são similares no *Linux* e no *Windows*.

1. crie uma pasta onde executará os próximos passos, como exemplo utilizaremos uma pasta chamada `meuapp`:

        cd ~/Documents
        mkdir meuapp
        cd meuapp
        cordova create .

2. Adicione a plataforma desejada, conforme a [documentação](https://cordova.apache.org/docs/en/latest/guide/platforms/android/#requirements-and-support):

    - <small>Para este exemplo utilizaremos `android@8.0.0`, compatível com ***API 19*** (*KitKat*) ~ ***28*** (*Pie*);</small>

            cordova platform add android@8.0.0
            cordova requirements

    - <small>Com o comando `cordova requirements` é possível verificar se todo os requisitos para compilar o app foram atendidos pelo sistema operacional;</small>

3. Faça o `build` do projeto, se este comando executar com sucesso, um novo apk do aplicativo será gerado:

        cordova build android