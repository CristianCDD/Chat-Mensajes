# cifrado.py
import sys

ABC = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789"
ABC_ESPEJO = ABC[::-1]
A = len(ABC)

def espejo(mensaje):
    res = ""
    for m in mensaje:
        if m in ABC:
            res += ABC_ESPEJO[ABC.index(m)]
        else:
            res += m
    return res

def cesar_encrypt(mensaje, desplazamiento=3):
    C = ""
    for m in mensaje:
        if m in ABC:
            new_pos = (ABC.index(m) + desplazamiento) % A
            C += ABC[new_pos]
        else:
            C += m
    return C

def cesar_decrypt(C_text, desplazamiento=3):
    mensaje = ""
    for c in C_text:
        if c in ABC:
            orig_pos = (ABC.index(c) - desplazamiento + A) % A
            mensaje += ABC[orig_pos]
        else:
            mensaje += c
    # revertir espejo
    return espejo(mensaje)

# Ejecutar desde PHP
# python cifrado.py accion mensaje
accion = sys.argv[1]
mensaje = sys.argv[2]

if accion == "encrypt":
    # espejo + cesar
    mensaje_espejado = espejo(mensaje)
    print(cesar_encrypt(mensaje_espejado))
elif accion == "decrypt":
    print(cesar_decrypt(mensaje))
