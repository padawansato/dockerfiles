FROM python:slim-buster

ENV PROJECT_DIR="/app/"

ADD app/ $PROJECT_DIR

WORKDIR $PROJECT_DIR

RUN pip install -r requirements.txt

CMD ["python", "wiki.py"]