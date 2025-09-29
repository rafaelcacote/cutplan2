<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfCnpjRule implements Rule
{
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true; // É nullable, então aceita valor vazio
        }
        
        // Remove caracteres não numéricos
        $documento = preg_replace('/[^0-9]/', '', $value);
        
        // Verifica se é CPF (11 dígitos) ou CNPJ (14 dígitos)
        if (strlen($documento) == 11) {
            return $this->validaCPF($documento);
        } elseif (strlen($documento) == 14) {
            return $this->validaCNPJ($documento);
        }
        
        return false;
    }
    
    public function message()
    {
        return 'O campo :attribute deve ser um CPF ou CNPJ válido.';
    }
    
    private function validaCPF($cpf)
    {
        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Verifica se não é uma sequência de números iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        
        return true;
    }
    
    private function validaCNPJ($cnpj)
    {
        // Verifica se tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }
        
        // Verifica se não é uma sequência de números iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
        
        // Calcula o primeiro dígito verificador
        $soma = 0;
        $pesos = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $pesos[$i];
        }
        $resto = $soma % 11;
        $dv1 = $resto < 2 ? 0 : 11 - $resto;
        
        if ($cnpj[12] != $dv1) {
            return false;
        }
        
        // Calcula o segundo dígito verificador
        $soma = 0;
        $pesos = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $pesos[$i];
        }
        $resto = $soma % 11;
        $dv2 = $resto < 2 ? 0 : 11 - $resto;
        
        return $cnpj[13] == $dv2;
    }
}
