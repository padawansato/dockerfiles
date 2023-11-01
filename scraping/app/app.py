import requests
from bs4 import BeautifulSoup

headers = {"User-Agent": "your user agent"}
# URL = "https://news.yahoo.co.jp/"
URL = "https://ja.wikipedia.org/wiki/%E3%81%93%E3%81%A1%E3%82%89%E8%91%9B%E9%A3%BE%E5%8C%BA%E4%BA%80%E6%9C%89%E5%85%AC%E5%9C%92%E5%89%8D%E6%B4%BE%E5%87%BA%E6%89%80_(%E3%82%A2%E3%83%8B%E3%83%A1)#%E5%90%84%E8%A9%B1%E3%83%AA%E3%82%B9%E3%83%88"
response = requests.get(URL, timeout=1, headers=headers)

# textでunicode, contentでstr
print(response.text)

soup = BeautifulSoup(response.text, 'lxml') #要素を抽出

for a_tag in soup.find_all('a'):
  print(a_tag.get('href')) #リンクを表示