### Case description

Implement a horse racing simulator with PHP and a relational database.

- Each horse has 3 stats: speed, strength, endurance
- Each stat ranges from 0.0 to 10.0
- A horse's speed is their base speed (5 m/s) + their speed stat (in m/s)
- Endurance represents how many hundreds of meters they can run at their best speed, before the weight of the jockey slows them down
- A jockey slows the horse down by 5 m/s, but this effect is reduced by the horse's strength * 8 as a percentage
- Each race is run by 8 randomly generated horses, over 1500m
- Up to 3 races are allowed at the same time

#### The webpage should include:

- A "create race" button which generates a new race of 8 random horses
- A button "progress" which advances all races by 10 "seconds" until all horses in the race have completed 1500m
- Any currently running races, showing distance covered, horse position, current time
- The last 5 race results (top 3 positions and times to complete 1500m)
- The best ever time, and the stats of the horse that generated it

Multiple users should be able to open the page and see the current results. Keep in mind,
that the focus of this code sample should be: clean code structure and usage of patterns
(mvc e.g.). The user interface can be just simple without graphics at all.
