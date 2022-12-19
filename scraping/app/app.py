import requests
from bs4 import BeautifulSoup

headers = {"User-Agent": "your user agent"}
URL = "https://news.yahoo.co.jp/"
response = requests.get(URL, timeout=1, headers=headers)

# textでunicode, contentでstr
print(response.text)

soup = BeautifulSoup(response.text, 'lxml') #要素を抽出

for a_tag in soup.find_all('a'):
  print(a_tag.get('href')) #リンクを表示