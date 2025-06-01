const shareData = {
    title: "BroLink",
    text: "Ajoute moi sur LevelUp !",
    url: document.getElementById("shareLink").innerHTML,
  };
  
  const btn = document.getElementById("share");
  const resultPara = document.querySelector(".result");
  
  // Share must be triggered by "user activation"
  btn.addEventListener("click", async () => {
    try {
        await     window.AndroidShareHandler.share(""+shareData.url);
        //resultPara.textContent = "MDN shared successfully on android";
      } catch (err) {
        console.log(`Error: ${err}`);
        resultPara.textContent = `Error: ${err}`;
        try {
            await navigator.share(shareData);
            //resultPara.textContent = "MDN shared successfully";
          } catch (err) {
            console.log(`Error: ${err}`);
          }
      }
    
  });