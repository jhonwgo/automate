CREATE TABLE Dependency (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    version VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE Repository (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    version VARCHAR(255),
);

CREATE TABLE RepositoryDependency (
    id INT NOT NULL AUTO_INCREMENT,
    repository INT,
    dependency INT,
    FOREIGN KEY (repository) REFERENCES Repository(id),
    FOREIGN KEY (dependency) REFERENCES Dependency(id)
);

