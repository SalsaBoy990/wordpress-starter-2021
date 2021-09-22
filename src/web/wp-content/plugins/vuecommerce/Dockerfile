# base image
FROM node:12.2.0-alpine

# set working directory
#RUN mkdir /usr/src/app
WORKDIR /usr/src/app

# add to $PATH
ENV PATH /usr/src/app/node_modules/.bin:$PATH
# install and cache app dependencies
COPY package.json /usr/src/app/package.json
RUN npm install
RUN npm install @vue/cli
COPY . /usr/src/app

# start app
CMD ["npm", "run", "serve"]
