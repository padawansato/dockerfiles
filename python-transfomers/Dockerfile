FROM python:3.9-slim-buster

RUN apt-get update \
    && apt-get install build-essential -y \
    && apt-get clean

RUN pip install --upgrade --no-cache-dir \
    ipython \
    jupyterlab \
    jupyter \
    jupyter-console \
    jupyterlab_code_formatter \
    autopep8

RUN pip install --no-cache-dir \
    torch==1.9.0+cpu -f https://download.pytorch.org/whl/torch_stable.html
RUN pip install --no-cache-dir \
    neologdn \
    tqdm \
    torch==1.9.0+cpu \
    transformers['ja']==4.8.2 

RUN jupyter notebook --generate-config -y \
  && sed -i \
    -e "s:^# c.NotebookApp.token = .*$:c.NotebookApp.token = u'':" \
    -e "s:^# c.NotebookApp.ip = .*$:c.NotebookApp.ip = '0.0.0.0':" \
    -e "s:^# c.NotebookApp.open_browser = .*$:c.NotebookApp.open_browser = False:" \
    /root/.jupyter/jupyter_notebook_config.py

RUN mkdir /workspace
WORKDIR /workspace

ENV SHELL=/bin/bash

CMD jupyter lab --ip=0.0.0.0 --no-browser --allow-root
