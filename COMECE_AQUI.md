# 🎯 COMECE AQUI - Guia Rápido

Bem-vindo ao **Gerenciador de Produtos**! Este arquivo fornece o caminho mais rápido para colocar a aplicação em funcionamento.

---

## ⚡ 3 Passos para Começar

### Passo 1: Clonar o Repositório
```bash
git clone https://github.com/niltonrvazdev/gerenciador-produto.git
cd gerenciador-produto
```

### Passo 2: Iniciar Docker
```bash
docker compose up -d --build
sleep 30
```

### Passo 3: Abrir no Navegador
Abra este link no seu navegador:
```
http://localhost:8000
```

✅ **Pronto!** A aplicação está funcionando!

---

## 🤖 Forma Automática (Recomendado)

Se você quer uma instalação totalmente automatizada:

```bash
./setup.sh
```

Este script:
- ✅ Valida se tem Docker instalado
- ✅ Inicia todos os containers
- ✅ Aguarda a inicialização
- ✅ Testa se a aplicação está respondendo
- ✅ Mostra um relatório do status

---

## 📚 Qual é o Próximo Passo?

Escolha uma opção abaixo:

| Se você quer... | Leia... |
|---|---|
| Entender cada passo em detalhes | [SETUP_GUIDE.md](./SETUP_GUIDE.md) |
| Diagnosticar problemas | [DEBUG_CHECKLIST.md](./DEBUG_CHECKLIST.md) |
| Entender o erro 502 que foi corrigido | [TROUBLESHOOTING.md](./TROUBLESHOOTING.md) |
| Ver que mudanças foram feitas | [CHANGELOG.md](./CHANGELOG.md) |
| Um resumo técnico da solução | [RESUMO_EXECUTIVO.md](./RESUMO_EXECUTIVO.md) |
| Informações gerais do projeto | [README.md](./README.md) |

---

## 🚨 Encontrou um Erro?

Execute este comando para fazer um diagnóstico automático:

```bash
./validate_502_fix.sh
```

Se o diagnóstico não resolver:

1. **Verifique os logs da aplicação:**
   ```bash
   docker compose logs -f app
   ```

2. **Reinicie tudo:**
   ```bash
   docker compose down -v
   docker compose up -d --build
   sleep 30
   ```

3. **Consulte [TROUBLESHOOTING.md](./TROUBLESHOOTING.md) para erros específicos**

---

## 🔧 Comandos Úteis Rápidos

```bash
# Ver se está funcionando
docker compose ps

# Acessar o terminal da aplicação
docker compose exec app bash

# Ver logs em tempo real
docker compose logs -f app

# Recompilar CSS/JavaScript
docker compose exec app npm run build

# Rodar migrations
docker compose exec app php artisan migrate

# Parar tudo
docker compose down
```

---

## 📝 Credenciais Padrão (Desenvolvimento)

```
Banco de Dados: laravel
Usuário BD: laravel
Senha BD: laravel
Root BD: root
```

---

## ❓ FAQ Rápido

**P: Preciso instalar PHP, Node, MySQL?**
R: Não! Tudo rodará dentro do Docker.

**P: A porta 8000 já está em uso, como mudo?**
R: Edite o `docker-compose.yml`, procure por `"8000:80"` e mude para `"8001:80"` (ou a porta que quiser).

**P: Como adiciono novos produtos?**
R: Acesse http://localhost:8000 e clique em "Dashboard" após fazer login.

**P: Como faço para parar a aplicação?**
R: Execute `docker compose down`

**P: Posso resetar o banco de dados?**
R: Sim, execute: `docker compose down -v && docker compose up -d --build`

---

## ✨ Funcionalidades Principais

- ✅ Interface web para gerenciar produtos
- ✅ Upload de imagens
- ✅ Busca e filtros
- ✅ API RESTful protegida
- ✅ Sistema de autenticação
- ✅ Dashboard responsivo

---

## 🎉 Parabéns!

Você tem tudo que precisa para começar a desenvolver. Se tiver dúvidas:

1. Consulte os guias em português acima
2. Verifique o arquivo de troubleshooting
3. Execute o script de diagnóstico

**Bom desenvolvimento!** 🚀

---

**Versão:** 1.0  
**Data:** 04/02/2026  
**Status:** ✅ Testado e funcionando
