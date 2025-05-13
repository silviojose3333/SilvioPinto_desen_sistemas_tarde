from selenium import webdriver
from selenium.webdriver.common.by import By
import time

#configuração do webDriver (nesse exemplo, estamos usando o chrome)
driver = webdriver.Chrome()

driver.get("file:///C:/Users/silvio_j_pinto/Documents/GitHub/SilvioPinto_desen_sistemas_tarde/teste_de_sistema/index.html")
          #   C:\Users\luiz_c_vaz\Documents\GitHub\LuizVaz_Desen_sistemas_tarde\teste_de_sistemas

#preenche o campo nome
nome_input = driver.find_element(By.ID, "name")
nome_input.send_keys("Joâo da Silva")

#preenche o campo CPF
cpf_input = driver.find_element(By.ID, "cpf")
cpf_input.send_keys("12345678901")

#preenche o campio endereço
endereco_input = driver.find_element(By.ID, "address")
endereco_input.send_keys("1Rua das Flores, 123")

#preenche o campio Telefone
telefone_input = driver.find_element(By.ID, "phone")
telefone_input.send_keys("11987653212")

#Clica no bortão de cadastrar
submit_button  = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
submit_button.click()
#Agguarde um momento para visulizar o resultado
#9em uma aplicação real, voce vericaria a resposta
time.sleep(3)

driver.quit()