# tcc-amicao
Repositório destinado ao versionamento e controle do projeto de conclusão de curso (TCC) - Aplicativo Amicao.


***Instrução de Refatoração do Histórico do Repositório em caso de adição de arquivos sensíveis. Pois toda vez que um arquivo sensível é commitado, ele pode
ser acessado via Checkout pelo hash do histórico, então não adianta fazer outro Commit com o dado sensível removido!
Segue a instrução:

1 - Instale o "git-filter-repo" na sua máquina. Ex: Arch Linux: yay -S git-filter-repo
2 - Vá até a pasta raiz do repositório, crie um arquivo .gitignore e adicione o caminho relativo deste arquivo até o arquivo sensível dentro deste mesmo. Ex linux:
	touch .gitignore
	sudo chmod -R 777 .gitignore
	echo "webapp/.env" >> .gitignore

	Levando em consideração que um .env por exemplo seria sensível.
3 - Adicione a alteração para pré-commit:
	git add .

4 - Refatore todo o histórico com git-filter-repo, isso consequentemente vai alterar todos os hashs do histórico:
	git-filter-repo --force --invert-paths --path [CAMINHO RELATIVO DE ATÉ O ARQUIVO SENSÍVEL]
	
	Por exemplo com o .env, com o terminal setado na pasta raíz deste projeto:
	git-filter-repo --force --invert-paths --path webapp/.env
	
5 - Após a refatoração, dê um commit e depois um push forçado (unico caso em que permitimos push forçado, além disto, pode ser falha de versionamento do próprio utilizador, e deve ser resolvida para que não haja a necessidade de push forçado!):
	git commit -m "Refactored all project to remove from history .env sensitive file  with git-filter-repo"
	git push --force origin main 



Avisos de utilização aos Colaboradores: 

1 - Sempre que uma hipótese de implementação for testada, CRIE UMA BRANCH (RAMIFICAÇÃO) do estado atual do projeto. Nunca, jamais dê Commit e Push pela
árvore Main ou Master. A oficialização da versão do projeto será feita após constar a real funcionalidade sem decorrência de outros problemas. 

2 - Na utlização do GIT: Sempre antes de fazer qualquer modificação no projeto, sincronize o projeto para receber todas as alterações anteriormente efetuadas. ** Também vale lembrar que você deve antes de commitar as suas modificações, fazer o git pull novamente e testar o projeto para constar se nenhuma alteração de outro contribuidor na rede não afetou a funcionalidade do projeto juntamente com suas alterações.

Git Pull (não confunda com git push) - Realiza um git fetch antes e aplica todas as alterações localmente.

3 - Adote a comunicação em equipe, pois combine e evite que mais de um contribuidor esteja modificando o mesmo arquivo, ou pelo menos, evite que mais de um contribuidor esteja modificando o mesmo objeto ou classe de um código fonte do qual pode afetar mutuamente toda uma funcionalidade.

4 - NUNCA, jamais, em hipotese nenhuma, DELETE UMA BRANCH, ou ramificação do projeto desde que não tenha certeza de que não será mais útil no estágio atual do projeto. Ou seja, apenas delete se tal hipótese de implementação fora completamente descartada por toda equipe.
