FROM nvidia/cuda:11.2.2-runtime-ubuntu20.04

RUN apt-get update -y \
    && apt-get install -y tzdata \
    && apt-get install -y \
     git bash-completion curl wget bzip2 vim build-essential \
     python3.9 python3.9-distutils python3.9-dev \
    && apt-get clean

RUN curl https://bootstrap.pypa.io/get-pip.py -o /tmp/get-pip.py \
  && python3.9 /tmp/get-pip.py

RUN pip3 install --upgrade --no-cache-dir \
    ipython \
    jupyterlab \
    jupyter \
    jupyter-console \
    jupyterlab_nvdashboard \
    jupyterlab_code_formatter \
    autopep8 \
    torch

RUN jupyter notebook --generate-config -y \
  && sed -i \
    -e "s:^# c.NotebookApp.token = .*$:c.NotebookApp.token = u'':" \
    -e "s:^# c.NotebookApp.ip = .*$:c.NotebookApp.ip = '0.0.0.0':" \
    -e "s:^# c.NotebookApp.open_browser = .*$:c.NotebookApp.open_browser = False:" \
    /root/.jupyter/jupyter_notebook_config.py

RUN mkdir /workspace
WORKDIR /workspace

### Install python packages
COPY requirements.txt requirements.txt
RUN pip install --upgrade pip \
&& pip install --no-cache-dir -r requirements.txt

ENV SHELL=/bin/bash

CMD jupyter lab --ip=0.0.0.0 --no-browser --allow-root
