import urllib.request, urllib.error
import click
from bs4 import BeautifulSoup
import socks, socket
import subprocess
import logging.config
import time
import random


# ランダムにスリープさせる
def wait():
    time.sleep(random.randint(2,5))


# Torを再起動する
def restart_tor():
    socks.set_default_proxy(socks.PROXY_TYPE_SOCKS5, '127.0.0.1', 9050)
    socket.socket = socks.socksocket
    # restart TOR
    subprocess.run(["killall -HUP tor"], shell=True)
    subprocess.run(["/etc/init.d/tor restart"], shell=True)


# clickパラメータはDockerコンテナ複数起動の検証で使用する
@click.command()
@click.option(
    "--seq",
    type=int,
    default=0,
    required=False
)
def scraping(seq):
    # logging.config.fileConfig("config/logging.ini")
    # logging.getLogger("__name__")

    for i in range(5):
        
        restart_tor()
        
        res = urllib.request.urlopen('http://checkip.dyndns.com/')
        html = BeautifulSoup(res, 'html.parser')
        current_ip = html.body.text.split(': ')[1]
        
        wait()

        # logging.info(f'[{seq}]Current IP address is {current_ip}')
        print(f'[{seq}]Current IP address is {current_ip}')


if __name__ == "__main__":
    scraping()