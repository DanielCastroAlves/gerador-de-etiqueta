# Gerador de Etiquetas para Sistema WMS

Este projeto é uma ferramenta web para gerar etiquetas com campos personalizáveis e códigos de barras, projetada para uso em sistemas de gestão de armazéns (WMS).

---

## Instalação

1. **Clone o repositório:**
   ```bash
 
   git clone https://github.com/DanielCastroAlves/gerador-de-etiqueta.git
   cd gerador-de-etiqueta
   ```

2. **Instale as dependências:**
   ```bash
   composer install
   ```

3. **Configure seu servidor web** para apontar para o diretório `public`.

---

## Uso

1. Preencha o formulário com os campos necessários:
   - Produto
   - Código de Barras
   - Peso
   - Data de Validade

2. Arraste e solte os campos dentro da pré-visualização da etiqueta para posicioná-los.

3. Ajuste as dimensões da etiqueta (largura e altura) conforme suas necessidades.

4. Clique em **Gerar Etiqueta** para criar uma etiqueta em PDF com as informações inseridas.

---

## Tecnologias Utilizadas

- Bootstrap 4
- jQuery UI
- TCPDF

---
