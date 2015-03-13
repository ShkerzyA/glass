#!/usr/bin/env python
#!-*- coding: utf-8 -*-

import os
import json

import tornado.web
import tornado.ioloop
import tornado.websocket

from tornado import template
from tornado.escape import linkify

#import pymongo

 

class MainHandler(tornado.web.RequestHandler):
    def get(self):
        #db = self.application.db
        #messages = db.chat.find()
        message=(self.get_argument('message'))
        print (message)
        for key, value in enumerate(application.webSocketsPool):
            #if value != self:
            value.ws_connection.write_message(message)
        #self.render('index.html', messages=messages)


class WebSocket(tornado.websocket.WebSocketHandler):
    def check_origin(self, origin):
        return True

    def open(self):
        print('open')
        self.application.webSocketsPool.append(self)

    def on_message(self, message):
        #db = self.application.db
        print(message)
        #db.chat.insert(message_dict)
        for key, value in enumerate(self.application.webSocketsPool):
            #if value != self:
            value.ws_connection.write_message(message)

    def on_close(self, message=None):
        print('close')
        for key, value in enumerate(self.application.webSocketsPool):
            if value == self:
                del self.application.webSocketsPool[key]

class Application(tornado.web.Application):
    def __init__(self):
        self.webSocketsPool = []

        place=os.path.abspath(os.path.dirname(__file__))
        settings = {
            'template_path': os.path.join(os.path.dirname(__file__), "templates"),
            'static_path': os.path.join(os.path.dirname(__file__), "static"),
            'static_url_prefix': '/static/',
        }
        #connection = pymongo.Connection('127.0.0.1', 27017)
        #self.db = connection.chat
        handlers = (
            (r'/', MainHandler),
            (r'/websocket/?', WebSocket),
            (r'/static/(.*)', tornado.web.StaticFileHandler,
             {'path': place+'static/'}),
        )

        tornado.web.Application.__init__(self, handlers, **settings)

application = Application()


if __name__ == '__main__':
    application.listen(8888)
    tornado.ioloop.IOLoop.instance().start()

