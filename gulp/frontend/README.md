Base web actualizada
===========================

Para trabajar:

1)

Clonar el repositorio y cambiar remotes por los del proyecto:

```
git clone git@github.com:jjacquesf/base-web.git nuevo-proyecto
cd nuevo-proyecto
git remote rm origin
git remote add origin {repo nuevo proyecto}
```

2)

Instalar paquetes npm principales
Una sola vez:

```
npm install -g gulp
npm install -g bower
```

3)

Instalar paquetes npm de la app y librerias web:
Cada vez que se haga git pull:

```
npm init
npm install
bower init
bower install
```

4)

Durante el desarrollo las librerias jquery/css solo se instalaran desde bower (expcepto maps)

Ej. 

```
bower install jquery --save
```
Una vez instalada se debe registrar en la llave vendor de: bundle.config.js para que gulp la compile

----

Se debe crear un archivo js por cada archivo html que necesite java script y deben estar almacendados en dev/js
