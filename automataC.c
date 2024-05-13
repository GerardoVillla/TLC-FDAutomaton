#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/* Definicion del automata por su tabla de transiciones,
su estado inicial y su conjunto de estados finales
especificando el número de finales
Autómata que acepta palabras en {0,1} con numero impar de 1s*/

char trans[12] = {'a', '1', 'b', 'a', '0', 'a', 'b', '1', 'a', 'b', '0', 'b'};
char inicial = 'a';
char finales[1] = {'b'};
int nfin = 1;

int final(char edo, char *finales, int nfin)
{
	int i = 0;
	for (i = 0; i < nfin; i++)
		if (edo == finales[i])
			return 1;
	return 0;
}

char pivote(char *transiciones, char edo, char caracter)
{
	int i = 0;
	while (edo != *(transiciones + (i * 3 * sizeof(char))) || caracter != *(transiciones + ((i * 3 + 1) * sizeof(char))))
		i++;
	return *(transiciones + ((i * 3 + 2) * sizeof(char)));
}

int main()
{
	int len, i;
	char actual, cadena[30];

	printf("Cadena a verificar: ");
	scanf("%s", cadena);
	len = strlen(cadena);
	actual = inicial;
	for (i = 0; i < len; i++)
		// Calcular el siguiente estado del automata
		actual = pivote(trans, actual, cadena[i]);
	if (final(actual, finales, nfin))
		printf("Palabra aceptada\n");
	else
		printf("Palabra rechazada\n");
	return 0;
}
