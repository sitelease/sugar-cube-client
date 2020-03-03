The Suger Cube Client, a Gitea API client for PHP
========

The Suger Cube Client allows you to send and recieve data from Gitea's RESTful API using object-oriented PHP.

### How does it work?
Under the hood, Suger Cube uses the [Guzzle Library](http://docs.guzzlephp.org/en/stable/) to make and send requests to [Gitea's RESTful API](https://try.gitea.io/api/swagger) routes. It then converts the returned JSON response data into PHP objects which you can use to easily query the data.

### Real world Example
To see how Sugar Cube can be used in a real world application please refer to [Acapella's code base](https://github.com/sitelease/acappella) (e.g. [line 39](https://github.com/sitelease/acappella/blob/1.0.0/src/Application/GiteaRepositoryManager.php#L39) of GiteaRepositoryManager.php).

### What's next?
- [ ] Add Example code to the README
- [ ] Create PHPUnit tests for each API requester
- [ ] Create more API requesters for Gitea's API routes
- [ ] Submit the Suger Cube composer package to Packagist

### Credits
* First thank you goes out to the folks over on the [Gitea.php](https://github.com/sab-international/gitea.php) project. Your Model and Push Event objects provided the foundation of this project.
* Next thank you goes to those who worked on [CompoLab](https://github.com/bricev/CompoLab). It was during the process of porting your great project to Gitea that we made this client.
* And last but not least, a big shout out to everyone who has contributed to [Gitea](https://github.com/go-gitea/gitea). Without your project there wouldn't be any API to make the client for ;)
