from selenium import webdriver
from selenium.webdriver.common.by import By
import time

#configuração do webDriver (nesse exemplo, estamos usando o chrome)
driver = webdriver.Chrome()

driver.get("file:///C:/Users/silvio_j_pinto/Documents/GitHub/SilvioPinto_desen_sistemas_tarde/teste_de_sistema/atv_cad_prod.html")
          #   C:\Users\luiz_c_vaz\Documents\GitHub\LuizVaz_Desen_sistemas_tarde\teste_de_sistemas

#preenche o campo nome
cod_input = driver.find_element(By.ID,"cod")
cod_input.send_keys("122")

#preenche o campo CPF
desc_input = driver.find_element(By.ID,"descricao")
desc_input.send_keys("um item utilizado para cortar lenha, chamado serra")

#preenche o campio endereço
mar_input = driver.find_element(By.ID,"marca")
mar_input.send_keys("Serrados")

#preenche o campio Telefone
pre_input = driver.find_element(By.ID,"preco")
pre_input.send_keys("548.90")

qnt_input = driver.find_element(By.ID,"qnt")
qnt_input.send_keys("20")

#Clica no bortão de cadastrar
submit_button  = driver.find_element(By.CSS_SELECTOR,"button[type='submit']")
submit_button.click()
#Agguarde um momento para visulizar o resultado
#9em uma aplicação real, voce vericaria a resposta
time.sleep(3)

driver.quit()