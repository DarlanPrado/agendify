# Etapa de build
FROM node:18-alpine as build-stage

WORKDIR /app

# Copiar arquivos de dependências e instalar dependências
COPY package*.json ./

RUN npm install -g pnpm
RUN pnpm install

# Copiar todo o projeto e construir
COPY . .

RUN pnpm run build

# Etapa de produção: servir com o nginx
FROM nginx:alpine

# Copiar arquivos estáticos gerados na build para o Nginx
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Expor a porta padrão do Nginx
EXPOSE 80

# Rodar o Nginx em modo foreground
CMD ["nginx", "-g", "daemon off;"]