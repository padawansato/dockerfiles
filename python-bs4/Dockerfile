FROM python:3.9-slim-buster

RUN mkdir -p /app
WORKDIR /app
COPY . /app

RUN apt-get update \
    && apt-get install build-essential tor privoxy -y \
    && apt-get clean

RUN pip install --upgrade pip \
    && pip install \
    pandas==1.4.0 \
    numpy==1.22.2 \
    beautifulsoup4==4.10.0 \
    lxml==4.7.1 \
    PySocks==1.7.1 \
    stem==1.8.0 \
    click==8.0.4 \
    autopep8

ENV SHELL=/bin/bash
